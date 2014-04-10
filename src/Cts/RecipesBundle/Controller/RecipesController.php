<?php

namespace Cts\RecipesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
    	return $this->render('CtsRecipesBundle:Front:search.html.twig', ['hr' => $hours, 'min' => $minutes]);
    }

    public function recipeDescriptionAction()
    {
        return $this->render('CtsRecipesBundle:Front:recipeDescription.html.twig');
    }

    public function makeFoodAction()
    {
        return $this->render('CtsRecipesBundle:Front:makeFood.html.twig');
    }
}
