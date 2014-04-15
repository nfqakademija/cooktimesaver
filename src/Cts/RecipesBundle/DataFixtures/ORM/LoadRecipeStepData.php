<?php 
namespace Cts\RecipesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Cts\RecipesBundle\Entity\RecipeStep;

class LoadRecipeStepData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $em)
	{
		$this->loadSoup($em);
	}

	public function loadSoup(ObjectManager $em)
	{
		$recipe_step = new RecipeStep();
		$recipe_step->setRecipe($this->getReference('soup'));
		$recipe_step->setTotalTime(786);
		$recipe_step->setDescription('Uzvirti Vandeni');
		$recipe_step->setImage('http://lorempixel.com/250/250/food/');
		$recipe_step->setTotalTimeCount(9);
		$recipe_step->setType(1);
		$this->addReference('soupstep1', $recipe_step);
		$em->persist($recipe_step);

		$recipe_step = new RecipeStep();
		$recipe_step->setRecipe($this->getReference('soup'));
		$recipe_step->setTotalTime(644);
		$recipe_step->setDescription('Suberti viska i puoda ir virti');
		$recipe_step->setImage('http://lorempixel.com/250/250/food/');
		$recipe_step->setTotalTimeCount(9);
		$recipe_step->setType(0);
		$this->addReference('soupstep2', $recipe_step);
		$em->persist($recipe_step);

		$recipe_step = new RecipeStep();
		$recipe_step->setRecipe($this->getReference('soup'));
		$recipe_step->setTotalTime(722);
		$recipe_step->setDescription('Supjaustyti darzoves');
		$recipe_step->setImage('http://lorempixel.com/250/250/food/');
		$recipe_step->setTotalTimeCount(9);
		$recipe_step->setType(1);
		$this->addReference('soupstep3', $recipe_step);
		$em->persist($recipe_step);

		$recipe_step = new RecipeStep();
		$recipe_step->setRecipe($this->getReference('soup'));
		$recipe_step->setTotalTime(145);
		$recipe_step->setDescription('Suberti likusias supjaustytas darzoves');
		$recipe_step->setImage('http://lorempixel.com/250/250/food/');
		$recipe_step->setTotalTimeCount(9);
		$recipe_step->setType(1);
		$this->addReference('soupstep4', $recipe_step);
		$em->persist($recipe_step);

		$em->flush();
	}



	public function getOrder()
	{
		return 4;
	}
}