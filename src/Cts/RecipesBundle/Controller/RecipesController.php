<?php

namespace Cts\RecipesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class RecipesController
 * @package Cts\RecipesBundle\Controller
 */
class RecipesController extends Controller
{
    /** Returns mainpage template
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('CtsRecipesBundle:Front:index.html.twig');
    }

    /** Recipe search method, returns search object
     * @param Request $request
     * @return Response object
     */
    public function searchAction(Request $request)
    {
        $sHours = $request->query->get('hours');
        $sHours = $sHours? $sHours : '00';
        $sMinutes = $request->query->get('minutes');
        $sMinutes = $sMinutes? $sMinutes : 20;

        return $this->render('CtsRecipesBundle:Front:search.html.twig', ['hr' => $sHours, 'min' => $sMinutes]);
    }

    /** Recipe step get method.
     * @param $id string
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return Response object
     */
    public function makeFoodAction($id, Request $request)
    {
        $oRecipe = $this->getRecipe($id);
        $sStepsCount = count($oRecipe->getRecipeStep());
        $sRecipe_img = $request->getUriForPath('/uploads/recipe_images/large/'. $oRecipe->getImg());
        $sRecipe_url = $request->getUriForPath('/make_food/'. $id);

        $urls = [
            'recipe_img' => $sRecipe_img,
            'recipe_url' => $sRecipe_url
        ];

        return $this->render('CtsRecipesBundle:Front:makeFood.html.twig', ['recipe' => $oRecipe, 'steps_count' => $sStepsCount, 'urls' => $urls]);
    }

    /** Recipe step click method.
     * @param $id string
     * @return Response object
     */
    public function clickedRecipeAction($id)
    {
        return $this->render('CtsRecipesBundle:Front:recipeDescription.html.twig', ['recipe' => $this->getRecipe($id)]);
    }

    /** Recipe getter method.
     * @param $id string
     * @return mixed / object
     */
    protected function getRecipe($id)
    {
        return $this->getDoctrine()->getRepository('CtsRecipesBundle:Recipe')->findOneById($id);
    }

    /** Search result method.
     * @param Request $request
     * @param $hours string
     * @param $minutes string
     * @return Response Object
     */
    public function searchResultsAction(Request $request, $hours, $minutes)
    {

        /** Returns 4 recipe objects in Descending order
         * @return object
         */
        $oRecipes = $this->getDoctrine()->getRepository('CtsRecipesBundle:Recipe');
        $sQuery = $oRecipes->createQueryBuilder('p')
            ->setMaxResults(4)
            ->orderBy('p.id', 'DESC')
            ->getQuery();
        $oMostPopular = $sQuery->getResult();

        $hours = $hours? $hours : '00';
        $minutes = $minutes? $minutes : 20;

        $products      = $request->get('products');
        $antiProducts  = $request->get('antiProducts');
        $totalMinutes  = ((int) $hours) * 60 + ((int) $minutes);

        $recipes = $this->get('cts_recipes.search_handler')->search($totalMinutes, $products, $antiProducts);

        return $this->render('CtsRecipesBundle:Front:searchResults.html.twig', ['recipes' => $recipes, 'popular' => $oMostPopular]);
    }

    /** Recipe ingredient tag method.
     * @param Request $request
     * @return JsonResponse
     */
    public function foodTagsAction(Request $request) {

        $tags = [];

        $searchKeyword = $request->get('q');
        $excludedIds = explode(",", $request->get('excludedIds'));

        $ingredients = $this->getDoctrine()->getRepository('CtsRecipesBundle:Ingredient');

        $query = $ingredients->createQueryBuilder('p')
            ->where('p.ingredient LIKE :word')
            ->andWhere('p.id NOT IN (:ids)')
            ->setParameter('word', $searchKeyword.'%')
            ->setParameter('ids', $excludedIds)
            ->getQuery();

        $searchResults = $query->getResult();

        foreach($searchResults as $searchResult){
            $tags[] = array('id' => $searchResult->getId(), 'title' => $searchResult->getIngredient());
        }

        return new JsonResponse($tags);
    }
}




