<?php

namespace Cts\RecipesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipesController extends Controller
{
    public function indexAction()
    {
        return $this->render('CtsRecipesBundle:Front:index.html.twig');
    }


    public function searchAction()
    {
    	return $this->render('CtsRecipesBundle:Front:search.html.twig');
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
