<?php 
namespace Cts\RecipesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Cts\RecipesBundle\Entity\RecipeStep;

class LoadRecipeStepData extends AbstractBasicData implements OrderedFixtureInterface
{
	public function load(ObjectManager $em)
	{
		$rec_step = $this->getRecipeFixtures('recipe_step.csv');
		foreach ($rec_step as $item) {
			$recipe_step = new RecipeStep();
			$recipe_step->setRecipe($this->getReference($item['RECIPE']));
			$recipe_step->setTotalTime($item['TOTALTIME']);
			$recipe_step->setDescription($item['DESC']);
			$recipe_step->setImage($item['IMG']);
			$recipe_step->setTotalTimeCount($item['TIMECOUNT']);
			$recipe_step->setType($item['TYPE']);

			$this->addReference( $item['RECIPE'].$item['STEP'], $recipe_step);
			$em->persist($recipe_step);
		
			$em->flush();
		}
	}

	public function getOrder()
	{
		return 4;
	}
}