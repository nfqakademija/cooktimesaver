<?php

namespace Cts\RecipesBundle\Steps;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Session\Session;

class StepsHandler implements StepsHandlerInterface{

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $recipeRepository;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $stepRepository;

    /**
     * @var StepsTree
     */
    private $treeService;

    /**
     * @var \Doctrine\Orm\EntityManager
     */
    private $em;

    public function __construct($em) {
        $this->em = $em;
        $this->recipeRepository = $em->getRepository('CtsRecipesBundle:Recipe');
        $this->stepRepository   = $em->getRepository('CtsRecipesBundle:RecipeStep');
    }

    /**
     * @param StepsTree $treeService
     */
    public function setTreeService($treeService)
    {
        $this->treeService = $treeService;
    }

    public function getSteps($recipeId, $completedStepId, $time){

        $recipe = $this->recipeRepository->find($recipeId);

        if(empty($recipe)) {
            throw $this->createNotFoundException(
                'No recipe found for id '.$recipeId
            );
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

            if(empty($completedNode)) {
                throw $this->createNotFoundException(
                    'No step found for id '.$completedStepId
                );
            }

            $this->updateCompletedStepStats($completedStepId, $time);

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

    /**
     * @param StepsNode $stepNode
     * @param Integer $time
     */
    private function updateCompletedStepStats($completedStepId, $time){

        /**
         * @var \Cts\RecipesBundle\Entity\RecipeStep $step
         */
        $step = $this->stepRepository->find($completedStepId);

        if(empty($step)) {
            throw $this->createNotFoundException(
                'No step found for id '.$completedStepId
            );
        }

        if($time != 0){
            $step->setTotalTime($step->getTotalTime() + $time);
            $step->setTotalTimeCount($step->getTotalTimeCount() + 1);
            $this->em->flush();
        }
    }
}
