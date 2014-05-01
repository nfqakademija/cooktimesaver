<?php

namespace Cts\RecipesBundle\Steps;

class StepsNode {

    private $value;

    private $parent;

    private $children = array();

    private $id;

    public function __construct($value = null, $id = null, $parentId = null) {

        $this->setValue($value);
        $this->setId($id);
        $this->setParent($parentId);

    }

    public function setId($id) {
        if(!empty($id)){
            $this->id = $id;
        }
    }

    public function getId() {
        return $this->id;
    }

    public function setValue($value) {
        if($this->value !== $value){
            $this->value = $value;
        }
    }

    public function getValue() {
        return $this->value;
    }

    public function getParent() {
        return $this->parent;
    }

    public function setParent($parent) {
        if($this->parent !== $parent){
            $this->parent = $parent;
        }
    }

    public function getChildren() {
        return $this->children;
    }

    public function setChild($child) {
        if(!empty($child)) {
            $this->children[] = $child;
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

