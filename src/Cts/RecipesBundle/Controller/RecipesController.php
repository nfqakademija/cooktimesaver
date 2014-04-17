<?php

namespace Cts\RecipesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $hours = $hours? $hours : 0;
        $minutes = $request->query->get('minutes');
        $minutes = $minutes? $minutes : 20;

        $repo = $this->getDoctrine()->getRepository('CtsRecipesBundle:Recipe');
        $query = $repo->createQueryBuilder('recipe')
                        ->where('recipe.time < :time')
                        ->setParameter('time', $minutes)
                        ->orderBy('recipe.time', 'ASC')
                        ->getQuery();
        $recipes = $query->getResult();

        // grazina receptus pagal nustatytas minutes, (valandos itakos neturi) var_dump kad susidarytum nuomone kas vyksta
        return $this->render('CtsRecipesBundle:Front:search.html.twig', ['hr' => $hours, 'min' => $minutes, 'recipes' => $recipes]);
    }

    public function makeFoodAction($id)
    {
        return $this->render('CtsRecipesBundle:Front:makeFood.html.twig');
    }

    public function clickedRecipeAction($id) {
        $recipe = $this->getDoctrine()->getRepository('CtsRecipesBundle:Recipe')->findOneById($id);
        return $this->render('CtsRecipesBundle:Front:recipeDescription.html.twig', ['recipe' => $recipe]);
    }
}
