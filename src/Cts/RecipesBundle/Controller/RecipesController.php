<?php

namespace Cts\RecipesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipesController extends Controller
{
    public function indexAction()
    {
        return $this->render('CtsRecipesBundle:Front:index.html.twig');
    }
}
