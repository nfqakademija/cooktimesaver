<?php

namespace Cts\RecipesBundle\Controller;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Cts\RecipesBundle\Steps\StepsTree;

class StepsController extends Controller {

    public function getStepsAction(Request $request, $recipeId, $completedStepId)
    {

        $response             = null;
        $stepData[]           = Array();
        $parentNodeChildren[] = Array();

        $session = new Session();
        $session->start();

        $recipe     = $this->getDoctrine()->getRepository('CtsRecipesBundle:Recipe')->find($recipeId);
        $stepsTree  = new StepsTree();

        if(empty($recipe)){
            throw new Exception("Such recipe doesn't exist");
        }

        $steps = $recipe->getRecipeStep();

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

            $stepsTree->createNode($stepData, $stepData['step_id'], $stepData['parent_id']);
        }

        if($completedStepId == 0) {

            $session->remove('completedSteps');
            $response = $stepsTree->getLeafs();

        } else {

            $completedNode = $stepsTree->getNode($completedStepId);

            if(empty($completedNode)){
                throw new Exception("Such step doesn't exist");
            }

            $completedNodeParentId = $completedNode->getParent();
            $parentNode            = $stepsTree->getNode($completedNodeParentId);

            if(!empty($parentNode)){
                $parentNodeChildren  = $parentNode->getChildren();

                $sessionStepsStack = $session->get('completedSteps');
                $sessionStepsStack = (array)$sessionStepsStack;
                array_push($sessionStepsStack, $completedStepId);
                $session->set('completedSteps', $sessionStepsStack);

                $containsInSessionStack = count(array_intersect($parentNodeChildren, $sessionStepsStack)) == count($parentNodeChildren);

                if($containsInSessionStack){
                    $response = $parentNode->getValue();
                }
            } else {
                //recepto pabaiga
            }
        }
        return new JsonResponse($response);
    }
}
