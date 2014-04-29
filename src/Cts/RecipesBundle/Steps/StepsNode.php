<?php

namespace Cts\RecipesBundle\Steps;

class StepsNode {

    private $_value;

    private $_parent;

    private $_children = array();

    private $_id;

    public function __construct($value = null, $id = null, $parentId = null) {

        $this->setValue($value);
        $this->setId($id);
        $this->setParent($parentId);

    }

    public function setId($id) {
        if(!empty($id)){
            $this->_id = $id;
        }
    }

    public function getId() {
        return $this->_id;
    }

    public function setValue($value) {
        if($this->_value !== $value){
            $this->_value = $value;
        }
    }

    public function getValue() {
        return $this->_value;
    }

    public function getParent() {
        return $this->_parent;
    }

    public function setParent($parent) {
        if($this->_parent !== $parent){
            $this->_parent = $parent;
        }
    }

    public function getChildren() {
        return $this->_children;
    }

    public function setChild($child) {
        if(!empty($child)) {
            $this->_children[] = $child;
        }
    }

    public function hasChildren() {
        $hasChildren = false;

        if(count($this->getChildren()) > 0) {
            $hasChildren = true;
        }
        return $hasChildren;
    }

}

