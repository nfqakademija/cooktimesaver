<?php

namespace Cts\RecipesBundle\Steps;

use Cts\RecipesBundle\Entity\Recipe;
use Cts\RecipesBundle\Entity\RecipeStep;
use Cts\RecipesBundle\Entity\StepRelationship;

class StepsTree{

    private $list = array();

    public function getTree() {
        return $this->list;
    }

    public function getNode($id) {

        $node = false;

        if(array_key_exists($id,$this->list) === true) {
            $node = $this->list[$id];
        }
        return $node;
    }

    public function setChild($id, $childId) {

        $node = $this->getNode($id);

        if($node !== false) {
            $node->setChild($childId);
        }else{

            //create node
        }
    }

    public function setParent($id, $parentId) {

        $node = $this->getNode($id);

        if($node !== false) {
            $node->setParent($parentId);
        }
    }

    public function createNode($value) {
        if(!isset($value)) {
            throw new Exception('A value is required to create a node');
        }

        $id       = $value['stepId'];
        $parentId = $value['parentId'];

        $node = new StepsNode($value, $id, $parentId);

        $this->list[$id] = $node;

        if(isset($parentId) && isset($this->list[$parentId])){
            $this->addChild($parentId, $id);
        }

        //Adds children later for the steps, if it was not found previously.
        $this->updateStepsTreeChildren($id, $node);

        return $id;
    }

    public function updateStepsTreeChildren($id, $node){
        foreach($this->list as $step){
            if($step->getParent() == $id){
                $node->setChild($step->getId());
            }
        }
    }

    public function addChild($parentId = null, $childId) {
        if(empty($childId)) {
            throw new \Exception('A id for the child is required.');
        }

        if($parentId == $childId){
            return $childId;
        }

        $this->setChild($parentId, $childId);

        $this->setParent($childId, $parentId);

        return $childId;
    }


    public function getChildren($id) {
        if(empty($id)) {
            throw new Exception('A ID is required.');
        }

        $node = $this->getNode($id);

        if($node !== false) {
            return $node->getChildren();
        }
    }

    public function getParent($id) {
        if(empty($id)) {
            throw new Exception('A ID is required.');
        }
        $ret = false;
        $node = $this->getNode($id);

        if($node !== false) {
            $ret = $node->getParent();
        }
        return $ret;
    }

    public function getValue($id) {
        if(empty($id)) {
            throw new Exception('A ID is required.');
        }

        $node = $this->getNode($id);
        return $node->getValue();
    }

    public function getLeafs(){

        $leafs = array();

        foreach($this->getTree() as $stepNode){
            if(!$stepNode->hasChildren()){
                $leafs[] = $stepNode->getValue();
            }
        }
        return $leafs;
    }

    /**
     * @param Recipe $recipe
     * @return $this
     */
    public function buildTree($recipe){

        $steps = $recipe->getRecipeStep();

        foreach ($steps as $step) {
            /** @var RecipeStep $step */
            $stepData = [];
            /** @var StepRelationship $stepRelationships */
            $stepRelationships             = $step->getStepRelationships();
            $stepData['stepId']            = $stepRelationships->getRecipeStepId();
            $stepData['parentId']          = $stepRelationships->getParentId();
            $stepData['description']       = $step->getDescription();
            $stepData['image']             = $step->getTotalTime();
            $stepData['totalTimeCount']    = $step->getTotalTimeCount();
            $stepData['image']             = $step->getImage();
            $stepData['type']              = $step->getType();

            $this->createNode($stepData);
        }
    }
}