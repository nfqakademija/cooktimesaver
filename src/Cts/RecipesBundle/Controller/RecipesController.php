<?php

namespace Cts\RecipesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class RecipesController extends Controller
{
    public function indexAction()
    {
        return $this->render('CtsRecipesBundle:Front:index.html.twig');
    }

    public function searchAction(Request $request)
    {
        $hours = $request->query->get('hours');
        $hours = $hours? $hours : '00';
        $minutes = $request->query->get('minutes');
        $minutes = $minutes? $minutes : 20;

        return $this->render('CtsRecipesBundle:Front:search.html.twig', ['hr' => $hours, 'min' => $minutes]);
    }

    public function makeFoodAction($id)
    {
        $recipe = $this->getRecipe($id);
        $stepsCount = count($recipe->getRecipeStep());
        return $this->render('CtsRecipesBundle:Front:makeFood.html.twig', ['recipe' => $recipe, 'steps_count' => $stepsCount]);
    }

    public function clickedRecipeAction($id)
    {
        return $this->render('CtsRecipesBundle:Front:recipeDescription.html.twig', ['recipe' => $this->getRecipe($id)]);
    }

    protected function getRecipe($id)
    {
        return $this->getDoctrine()->getRepository('CtsRecipesBundle:Recipe')->findOneById($id);
    }

    public function searchResultsAction(Request $request, $hours, $minutes) {

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

    public function foodTagsAction(Request $request) {

        $tags = array();

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




