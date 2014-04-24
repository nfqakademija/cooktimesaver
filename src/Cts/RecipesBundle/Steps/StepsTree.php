<?php

namespace Cts\RecipesBundle\Steps;

class StepsTree {

    private $_list = array();

    public function __construct() {

    }

    public function getTree() {
        return $this->_list;
    }

    public function getNode($id) {

        $ret = false;

        if(array_key_exists($id,$this->_list) === true) {
            $ret = $this->_list[$id];
        }
        return $ret;
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

        if(isset($parentId) && !isset($this->_list[$parentId])){
            $parentNode = new StepsNode(null, $parentId);
            $this->_list[$parentId] = $parentNode;
        }

        if(isset($parentId) && isset($this->_list[$parentId])){
            $this->addChild($parentId, $id);
        }

        return $id;
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

        $leafs = Array();

        foreach($this->getTree() as $step){
            if($step->getChildren() == null){
                $leafs[] = $step->getValue();
            }
        }
        return $leafs;
    }

}