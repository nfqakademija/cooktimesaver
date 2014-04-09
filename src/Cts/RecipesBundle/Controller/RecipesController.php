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
    	$recipe = $this->get('cts_recipes.recipes_collection');
    	return $this->render('CtsRecipesBundle:Front:search.html.twig', ['recipes' => $recipe->getRecipes()]);
    }
}
