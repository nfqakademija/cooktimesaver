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

    public function searchResultsAction($hours, $minutes) {
        // Imituojam ilga load:
        usleep(500000);
        $hours = $hours? $hours : '00';
        $minutes = $minutes? $minutes : 20;

        $sum_minutes = ((int) $hours) * 60 + ((int) $minutes);

        $repo = $this->getDoctrine()->getRepository('CtsRecipesBundle:Recipe');
        $query = $repo->createQueryBuilder('recipe')
            ->where('recipe.time < :time')
            ->setParameter('time', $sum_minutes)
            ->orderBy('recipe.time', 'ASC')
            ->getQuery();
        $recipes = $query->getResult();

        return $this->render('CtsRecipesBundle:Front:searchResults.html.twig', ['recipes' => $recipes]);
    }

    public function foodTagsAction() {
        $tags = array();

        $ingredients = $this->getDoctrine()->getRepository('CtsRecipesBundle:Ingredient')->findAll();

        foreach($ingredients as $ingredient){
            $tags['food'][] = array('id' => $ingredient->getId(), 'title' => $ingredient->getIngredient());
        }

        return new JsonResponse($tags);
    }
}
