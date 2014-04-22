<?php

namespace Cts\RecipesBundle\Steps;

use RecursiveIterator;
use ArrayIterator;

class StepsTreeIterator extends ArrayIterator implements RecursiveIterator {

    private $_list = array();

    private $_next = array();

    private $_position;

    public function __construct(array $list, array $tree = null) {
        $this->_list = $list;

        if(is_null($tree)) {
            reset($this->_list);
            $next = current($this->_list);
            $this->_next = $next->getChildren();
        } else {
            $this->_next = $tree;
        }

        parent::__construct($this->_next);
    }

    public function current() {
        $current = parent::current();
        $nObj = $this->_list[$current];
        return $nObj;
    }

    public function key() {
        $key = parent::key();
        $key = $this->_next[$key];
        return $key;
    }

    public function hasChildren() {
        $next = $this->_list[$this->key()];
        $next = $next->anyChildren();
        return $next;
    }

    public function getChildren() {
        $childObj = $this->_list[$this->key()];
        $children = $childObj->getChildren();
        return new StepsTreeIterator($this->_list, $children);
    }
}

