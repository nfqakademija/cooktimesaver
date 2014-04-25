<?php

namespace Cts\RecipesBundle\Steps;

class StepsTree {

    private $_list = array();

    private $_leafs = array();

    public function getTree() {
        return $this->_list;
    }

    public function getNode($id) {

        $node = false;

        if(array_key_exists($id,$this->_list) === true) {
            $node = $this->_list[$id];
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

    public function createNode($value, $id = null, $parentId = null) {
        if(!isset($value)) {
            throw new Exception('A value is required to create a node');
        }

        $node = new StepsNode($value, $id, $parentId);
        $this->_list[$id] = $node;

        if(isset($parentId) && isset($this->_list[$parentId])){
            $this->addChild($parentId, $id);
        }

        //Adds children later for the steps, if it was not found previously.
        $this->updateStepsTreeChildren($id, $node);

        return $id;
    }

    public function updateStepsTreeChildren($id, $node){
        foreach($this->_list as $step){
            if($step->getParent() == $id){
                $node->setChild($step->getId());
            }
        }
    }

    public function addChild($parentId = null, $childId) {
        if(empty($childId)) {
            throw new Exception('A id for the child is required.');
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
        foreach($this->getTree() as $stepNode){
            if(!$stepNode->hasChildren()){
                $this->leafs[] = $stepNode->getValue();
            }
        }
        return $this->leafs;
    }

}