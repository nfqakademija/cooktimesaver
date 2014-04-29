<?php
/**
 * Created by PhpStorm.
 * User: Rolandas
 * Date: 4/29/14
 * Time: 2:43 PM
 */

namespace Cts\RecipesBundle\Steps;


Interface StepsHandlerInterface {
    public function getSteps($recipeId, $completedStepId);
} 