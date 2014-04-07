<?php

namespace Cts\RecipesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Cts\RecipesBundle\Services;

class RecipesController extends Controller
{
    public function indexAction()
    {
        return $this->render('CtsRecipesBundle:Front:index.html.twig');
    }


    public function searchAction()
    {
    	$recipe = $this->get('recipe');
    	return $this->render('CtsRecipesBundle:Front:search.html.twig', ['recipe' => $recipe]);
    }
}
