<?php

namespace Cts\RecipesBundle\Steps;

Use Exception;

class StepsNode {

    private $_value;

    private $_parent;

    private $_children = array();

    private $_id;

    public function __construct($value = null, $id = null, $parentId = null) {

        $this->setId($id);
        $this->setValue($value);
        $this->setParent($parentId);

    }

    public function setId($id = null) {
        if(empty($id)) {
            $this->_id = uniqid();
        } else {
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

    public function anyChildren() {
        $ret = false;

        if(count($this->_children) > 0) {
            $ret = true;
        }
        return $ret;
    }

}

