<?php

namespace Cts\RecipesBundle\Steps;

use RecursiveIteratorIterator;
use Exception;

class StepsTreeRecursiveIterator extends RecursiveIteratorIterator {

    private $_stepsTree;

    private $level;

    private $maxDepth;

    private $stepIds = Array();

    public function __construct(StepsTree $st, $iterator, $mode = RecursiveIteratorIterator::LEAVES_ONLY, $flags = 0) {

        parent::__construct($iterator, $mode, $flags);
        $this->_stepsTree = $st;

    }

    public function getMaxDepth(){

        $this->maxDepth = 0;

        parent::rewind();
        while ($this->valid()) {
            if(parent::getDepth() > $this->maxDepth){
                $this->maxDepth = parent::getDepth();
            }
            $this->next();
        }
        return $this->maxDepth;

    }

    public function getLevelOf($step_id){
        if(empty($step_id)) {
            throw new Exception('A step id is required.');
        }

        parent::rewind();
        while ($this->valid()) {
            if($this->current()->getArrayValue('step_id') == $step_id ){
                $this->level = $this->getDepth();
            }
            $this->next();
        }
        return $this->level;

     }

    public function getStepsOf($level = 0){

        if($this->getMaxDepth() < $level) {
            throw new Exception('There is no such level.');
        }

        $stepsData = array();

        parent::rewind();
        while ($this->valid()) {
            if(parent::getDepth() == $level){
                $stepsData[] = $this->current()->getValue();
            }
            $this->next();
        }
        return $stepsData;
    }

    public function getFirstSteps(){

        return $this->getStepsOf($this->getMaxDepth());

    }

    public function getLevelStepsIdsById($id){

        $this->level = $this->getLevelOf($id);

        parent::rewind();
        while ($this->valid()) {
            if($this->getDepth() == $this->level){
                $this->stepIds[] = $this->current()->getArrayValue('step_id');
            }
            $this->next();
        }
        return $this->stepIds;

    }

}