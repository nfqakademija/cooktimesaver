<?php

namespace Cts\RecipesBundle\Controller;

use Cts\RecipesBundle\Entity\StepRelationship;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
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

        $response             = null;
        $stepData[]           = Array();
        $parentNodeChildren[] = Array();

        $session = new Session();
        $session->start();

        $recipe     = $this->getDoctrine()->getRepository('CtsRecipesBundle:Recipe')->find($recipeId);
        $stepTree   = new StepsTree();

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

            $stepTree->createNode($stepData, $stepData['step_id'], $stepData['parent_id']);
        }

        if($completedStepId == 0) {

            $session->remove('completedSteps');
            $response = $stepTree->getLeafs();

        } else {

            $completedNode = $stepTree->getNode($completedStepId);

            if(empty($completedNode)){
                throw new Exception("Such step doesn't exist");
            }

            $completedNodeParentId = $completedNode->getParent();
            $parentNode            = $stepTree->getNode($completedNodeParentId);

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
