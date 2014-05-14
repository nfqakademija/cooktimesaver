<?php

namespace Cts\RecipesBundle\Steps;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StepsHandler implements StepsHandlerInterface{

    /**
     * @var \Doctrine\Orm\EntityRepository
     */
    private $recipeRepository;

    /**
     * @var \Doctrine\Orm\EntityRepository
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

    /**
     * @var \Symfony\Component\HttpFoundation\Session
     */
    private $session;

    public function __construct($em) {
        $this->em = $em;
        $this->recipeRepository = $em->getRepository('CtsRecipesBundle:Recipe');
        $this->stepRepository   = $em->getRepository('CtsRecipesBundle:RecipeStep');
        $this->session = new Session();
    }

    /**
     * @param StepsTree $treeService
     */
    public function setTreeService($treeService)
    {
        $this->treeService = $treeService;
    }

    public function getSteps($recipeId, $completedStepId, $time){

        $steps  = null;
        $recipe = $this->recipeRepository->find($recipeId);

        if(empty($recipe)) {
            throw new NotFoundHttpException(
                'No recipe found for id '.$recipeId
            );
        }

        $stepsTree = $this->treeService;
        $stepsTree->buildTree($recipe);

        if($completedStepId == 0) {
            $this->session->remove('completedSteps');
            $steps = $stepsTree->getLeafs();
        } else {
            $completedNode = $stepsTree->getNode($completedStepId);

            if(empty($completedNode)) {
                throw new NotFoundHttpException(
                    'No step found for id '.$completedStepId
                );
            }

            $this->updateCompletedStepStats($completedStepId, $time);
            $this->addCompletedStepIdToSession($completedStepId);

            $completedNodeParentId = $completedNode->getParent();
            $parentNode            = $stepsTree->getNode($completedNodeParentId);

            if(!empty($parentNode)){
                if($this->isChildrenContainsInSession($parentNode)){
                    $steps = $parentNode->getValue();
                }
            } else {
                //recepto pabaiga
            }
        }
        return $steps;
    }

    /**
     * @param string $completedStepId
     * @param integer $time
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    private function updateCompletedStepStats($completedStepId, $time){

        /**
         * @var \Cts\RecipesBundle\Entity\RecipeStep $step
         */
        $step = $this->stepRepository->find($completedStepId);

        if(empty($step)) {
            throw new NotFoundHttpException(
                'No step found for id '.$completedStepId
            );
        }

        if($time != 0){
            $step->setTotalTime($step->getTotalTime() + $time);
            $step->setTotalTimeCount($step->getTotalTimeCount() + 1);
            $this->em->flush();
        }
    }

    /**
     * @param StepsNode $parentNode
     * @return bool
     */
    private function isChildrenContainsInSession($parentNode){

        $sessionStepsStack = $this->session->get('completedSteps');

        $parentNodeChildren = $parentNode->getChildren();
        $isChildrenContainsInSession = count(array_intersect($parentNodeChildren, $sessionStepsStack)) == count($parentNodeChildren);

        return $isChildrenContainsInSession;
    }

    /**
     * @param Integer $completedStepId
     */
    private function addCompletedStepIdToSession($completedStepId){

        $sessionStepsStack = $this->session->get('completedSteps');
        $sessionStepsStack = (array)$sessionStepsStack;
        array_push($sessionStepsStack, $completedStepId);
        $this->session->set('completedSteps', $sessionStepsStack);

    }
}
