<?php

namespace Cts\RecipesBundle\Controller;

use Cts\RecipesBundle\Entity\StepRelationship;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Cts\RecipesBundle\Steps\StepsTreeRecursiveIterator;
use Cts\RecipesBundle\Steps\StepsTree;
use Cts\RecipesBundle\Steps\StepsTreeIterator;

class StepsController extends Controller {

    public function getStepsAction(Request $request, $recipeId, $completedStepId)
    {

        $response = null;

        $session = new Session();
        $session->start();

        $recipe     = $this->getDoctrine()->getRepository('CtsRecipesBundle:Recipe')->find($recipeId);

        $stepTree   = new StepsTree();
        $steps      = $recipe->getRecipeStep();
        $stepData[] = Array();

        foreach ($steps as $step) {

            $stepData = null;

            $stepRelationships             = $step->getStepRelationships();
            $stepData['step_id']           = $stepRelationships->getRecipeStepId();
            $stepData['parent_id']         = $stepRelationships->getParentId();
            $stepData['description']       = $step->getDescription();
            $stepData['image']             = $step->getTotalTime();
            $stepData['total_time_count']  = $step->getTotalTimeCount();
            $stepData['image']             = $step->getImage();
            $stepData['type']              = $step->getType();

            $stepTree->createNode($stepData, $stepData['step_id'], $stepData['parent_id']);
        }

        $stepsIterator = new StepsTreeRecursiveIterator($stepTree, new StepsTreeIterator($stepTree->getTree()), true);

        if($completedStepId == 0) {

            $session->remove('completedSteps');
            $response = $stepsIterator->getFirstSteps();

        } else {

            $currentLevelStepsIds = $stepsIterator->getLevelStepsIdsById($completedStepId);
            $sessionStepsStack    = $session->get('completedSteps');

            $sessionStepsStack = (array)$sessionStepsStack;

            array_push($sessionStepsStack, $completedStepId);
            $session->set('completedSteps', $sessionStepsStack);

            $containsInSessionStack = count(array_intersect($currentLevelStepsIds, $sessionStepsStack)) == count($currentLevelStepsIds);

            if($containsInSessionStack){
                $parentStepId = $stepTree->getNode($completedStepId)->getParent();
                if($parentStepId){
                    $level    = $stepsIterator->getLevelOf($parentStepId);
                    $response = $stepsIterator->getStepsOf($level);
                } else {
                    //jei nera parentid, receipto pabaiga
                }
            }
        }
        return new JsonResponse($response);
    }

} 