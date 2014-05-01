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

        $sum_minutes = ((int) $hours) * 60 + ((int) $minutes);

        $repo = $this->getDoctrine()->getRepository('CtsRecipesBundle:Recipe');
        $query = $repo->createQueryBuilder('recipe')
                        ->where('recipe.time < :time')
                        ->setParameter('time', $sum_minutes)
                        ->orderBy('recipe.time', 'ASC')
                        ->getQuery();
        $recipes = $query->getResult();

        // grazina receptus pagal nustatytas minutes, (valandos itakos neturi) var_dump kad susidarytum nuomone kas vyksta
        return $this->render('CtsRecipesBundle:Front:search.html.twig', ['hr' => $hours, 'min' => $minutes, 'recipes' => $recipes]);
    }

    public function makeFoodAction($id)
    {
        $recipe = $this->getDoctrine()->getRepository('CtsRecipesBundle:Recipe')->findOneById($id);
        return $this->render('CtsRecipesBundle:Front:makeFood.html.twig', ['recipe' => $recipe]);
    }

    public function clickedRecipeAction($id) {
        $recipe = $this->getDoctrine()->getRepository('CtsRecipesBundle:Recipe')->findOneById($id);
        return $this->render('CtsRecipesBundle:Front:recipeDescription.html.twig', ['recipe' => $recipe]);
    }

    public function searchResultsAction(Request $request, $hours, $minutes) {
        // Imituojam ilga load:
        usleep(50000);
        $hours = $hours? $hours : '00';
        $minutes = $minutes? $minutes : 20;

        $products     = explode(",", $request->get('products'));
        $antiProducts = explode(",", $request->get('antiProducts'));
        $sum_minutes  = ((int) $hours) * 60 + ((int) $minutes);

        $recipes = $this->get('cts_recipes.search_handler')->search($sum_minutes, $products, $antiProducts);

        return $this->render('CtsRecipesBundle:Front:searchResults.html.twig', ['recipes' => $recipes]);
    }

    public function foodTagsAction(Request $request) {

        $tags = array();

        $searchKeyword = $request->get('q');

        $ingredients = $this->getDoctrine()->getRepository('CtsRecipesBundle:Ingredient');

        $query = $ingredients->createQueryBuilder('p')
            ->where('p.ingredient LIKE :word')
            ->setParameter('word', $searchKeyword.'%')
            ->getQuery();

        $searchResults = $query->getResult();

        foreach($searchResults as $searchResult){
            $tags['food'][] = array('id' => $searchResult->getId(), 'title' => $searchResult->getIngredient());
        }

        return new JsonResponse($tags);
    }
}




