<?php 
namespace Cts\RecipesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Cts\RecipesBundle\Entity\RecipeIngredient;

class LoadRecipeIngredientsData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $em)
	{
		$this->loadSoup($em);
		$this->loadStake($em);
	}

	public function loadSoup($em)
	{
		$recipe_ingredients = new RecipeIngredient();
		$recipe_ingredients->setRecipe($this->getReference('soup'));
		$recipe_ingredients->setIngredient($this->getReference('Bulves'));
		$recipe_ingredients->setAmount('3vnt');
		$em->persist($recipe_ingredients);

		$recipe_ingredients = new RecipeIngredient();
		$recipe_ingredients->setRecipe($this->getReference('soup'));
		$recipe_ingredients->setIngredient($this->getReference('Morkos'));
		$recipe_ingredients->setAmount('1vnt');
		$em->persist($recipe_ingredients);

		$recipe_ingredients = new RecipeIngredient();
		$recipe_ingredients->setRecipe($this->getReference('soup'));
		$recipe_ingredients->setIngredient($this->getReference('Pomidorai'));
		$recipe_ingredients->setAmount('2vnt');
		$em->persist($recipe_ingredients);

		$recipe_ingredients = new RecipeIngredient();
		$recipe_ingredients->setRecipe($this->getReference('soup'));
		$recipe_ingredients->setIngredient($this->getReference('Druskos'));
		$recipe_ingredients->setAmount('saukstas');
		$em->persist($recipe_ingredients);

		$em->flush();
	}

	public function loadStake($em)
	{
		$recipe_ingredients = new RecipeIngredient();
		$recipe_ingredients->setRecipe($this->getReference('stake'));
		$recipe_ingredients->setIngredient($this->getReference('Bulves'));
		$recipe_ingredients->setAmount('4vnt');
		$em->persist($recipe_ingredients);

		$recipe_ingredients = new RecipeIngredient();
		$recipe_ingredients->setRecipe($this->getReference('stake'));
		$recipe_ingredients->setIngredient($this->getReference('Jautiena'));
		$recipe_ingredients->setAmount('400g');
		$em->persist($recipe_ingredients);

		$recipe_ingredients = new RecipeIngredient();
		$recipe_ingredients->setRecipe($this->getReference('stake'));
		$recipe_ingredients->setIngredient($this->getReference('Pomidorai'));
		$recipe_ingredients->setAmount('4vnt');
		$em->persist($recipe_ingredients);

		$recipe_ingredients = new RecipeIngredient();
		$recipe_ingredients->setRecipe($this->getReference('stake'));
		$recipe_ingredients->setIngredient($this->getReference('Salieras'));
		$recipe_ingredients->setAmount('200g');
		$em->persist($recipe_ingredients);

		$em->flush();
	}

	public function loadMilkshake($em)
	{
		$recipe_ingredients = new RecipeIngredient();
		$recipe_ingredients->setRecipe($this->getReference('milkshake'));
		$recipe_ingredients->setIngredient($this->getReference('Pienas'));
		$recipe_ingredients->setAmount('500ml');
		$em->persist($recipe_ingredients);

		$recipe_ingredients = new RecipeIngredient();
		$recipe_ingredients->setRecipe($this->getReference('milkshake'));
		$recipe_ingredients->setIngredient($this->getReference('Avietes'));
		$recipe_ingredients->setAmount('100g');
		$em->persist($recipe_ingredients);

		$em->flush();
	}

	public function getOrder()
	{
		return 3;
	}
}



 ?>