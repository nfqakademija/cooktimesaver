<?php 
namespace Cts\RecipesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Cts\RecipesBundle\Entity\RecipeIngredient;

class LoadRecipeIngredientsData extends AbstractBasicData implements OrderedFixtureInterface
{
	public function load(ObjectManager $em)
	{
		$recipe_ingred = $this->getRecipeFixtures('recipe_ingredients.csv');
		// var_dump($recipe_ingred);
		foreach ($recipe_ingred as $item) {
			$recipe_ingredients = new RecipeIngredient();
			$recipe_ingredients->setRecipe($this->getReference($item['RECIPE']));
			$recipe_ingredients->setIngredient($this->getReference($item['INGREDIENT']));
			$recipe_ingredients->setAmount($item['AMOUNT']);
			$em->persist($recipe_ingredients);
			$em->flush();
		}
	}

	public function getOrder()
	{
		return 3;
	}
}
