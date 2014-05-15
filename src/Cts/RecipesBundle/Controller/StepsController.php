<?php

namespace Cts\RecipesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class StepsController extends Controller {

    public function getStepsAction($recipeId, $completedStepId, $completedStepTime)
    {
        $steps = $this->get('cts_recipes.steps_handler')->getSteps($recipeId, $completedStepId, $completedStepTime);
        //return new JsonResponse($steps);
        return $this->render('CtsRecipesBundle:Front:loadedStep.html.twig', ['steps' => $steps]);
    }
}
