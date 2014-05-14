<?php 
namespace Cts\RecipesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Cts\RecipesBundle\Entity\Ingredient;

class LoadIngredientData extends AbstractBasicData implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$ingredients = $this->getRecipeFixtures('ingredient.csv');
		foreach ($ingredients as $item) 
		{
			$ingredient = new Ingredient();
			$ingredient->setIngredient($item['INGREDIENT']);
			$manager->persist($ingredient);	
			$manager->flush();
			$this->addReference($item['INGREDIENT'], $ingredient);
		}
	}
	public function getOrder()
	{
		return 1;
	}
}
