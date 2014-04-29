<?php

namespace Cts\RecipesBundle\Steps;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Session\Session;

class StepsHandler implements StepsHandlerInterface{
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $repository;

    /**
     * @var StepsTree
     */
    private $treeService;

    public function __construct($em) {
        $this->repository = $em->getRepository('CtsRecipesBundle:Recipe');
    }

    /**
     * @param StepsTree $treeService
     */
    public function setTreeService($treeService)
    {
        $this->treeService = $treeService;
    }

    public function getSteps($recipeId, $completedStepId){

        $recipe = $this->repository->find($recipeId);

        if(empty($recipe)){
            throw new Exception("Such recipe doesn't exist");
        }

        $steps = null;
        $session = new Session();
        $session->start();

        $stepsTree = $this->treeService;
        $stepsTree->buildTree($recipe);

        if($completedStepId == 0) {

            $session->remove('completedSteps');
            $steps = $stepsTree->getLeafs();

        } else {

            $completedNode = $stepsTree->getNode($completedStepId);

            if(empty($completedNode)){
                throw new Exception("Such step doesn't exist");
            }

            $completedNodeParentId = $completedNode->getParent();
            $parentNode            = $stepsTree->getNode($completedNodeParentId);

            if(!empty($parentNode)){
                $parentNodeChildren = $parentNode->getChildren();

                $sessionStepsStack = $session->get('completedSteps');
                $sessionStepsStack = (array)$sessionStepsStack;
                array_push($sessionStepsStack, $completedStepId);
                $session->set('completedSteps', $sessionStepsStack);

                $containsInSessionStack = count(array_intersect($parentNodeChildren, $sessionStepsStack)) == count($parentNodeChildren);

                if($containsInSessionStack){
                    $steps = $parentNode->getValue();
                }
            } else {
                //recepto pabaiga
            }
        }
        return $steps;
    }

}
