<?php
namespace Cts\RecipesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Cts\RecipesBundle\Entity\Recipe;

class LoadRecipeData extends AbstractBasicData implements OrderedFixtureInterface
{
	
	public function load(ObjectManager $em)
	{
		$recipes = $this->getRecipeFixtures('recipe.csv');
		foreach ($recipes as $item) {
			$recipe = new Recipe();
			$recipe->setTitle($item['TITLE']);
			$recipe->setImg($item['IMG']);
			$recipe->setDescription($item['DESCRIPTION']);
			$recipe->setTime($item['TIME']);
			$em->persist($recipe);
			$em->flush();
			$this->addReference($item['ID'], $recipe);								
		}
	}

	public function getOrder()
	{
		return 2;
	}
}
