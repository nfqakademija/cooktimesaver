<?php

namespace Cts\RecipesBundle\Steps;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class StepsHandler implements StepsHandlerInterface, ContainerAwareInterface{

    private $repository;

    private $container;

    public function __construct($em, $container) {
        $this->repository = $em->getRepository('CtsRecipesBundle:Recipe');
        $this->setContainer($container);
    }

    public function getSteps($recipeId, $completedStepId){

        $recipe = $this->repository->find($recipeId);

        if(empty($recipe)){
            throw new Exception("Such recipe doesn't exist");
        }

        $response = null;
        $session = new Session();
        $session->start();

        $stepsTree = $this->container->get('steps_tree')->buildTree($recipe);

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
                $parentNodeChildren = $parentNode->getChildren();

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

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
