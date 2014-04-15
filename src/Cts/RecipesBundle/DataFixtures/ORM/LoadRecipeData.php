<?php
namespace Cts\RecipesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Cts\RecipesBundle\Entity\Recipe;

class LoadRecipeData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $em)
	{
		$this->loadSoup($em);
		$this->loadStake($em);
	}

	public function loadSoup($em)
	{
		$recipe = new Recipe();
		$recipe->setTitle('Darzoviu Sriuba');
		$recipe->setImg('http://lorempixel.com/250/250/food/');
		$recipe->setDescription('Aprasymas apie Ruosiama recepta! Pats aprasymas nera ilgas.');
		$recipe->setTime(24);
		$em->persist($recipe);
		$em->flush();
		$this->addReference('soup', $recipe);
	}

	public function loadStake($em)
	{
		$recipe = new Recipe();
		$recipe->setTitle('Jautienos Troskinys');
		$recipe->setImg('http://lorempixel.com/250/250/food/');
		$recipe->setDescription('Aprasymas apie Ruosiama recepta! Pats aprasymas nera ilgas.');
		$recipe->setTime(45);
		$em->persist($recipe);
		$em->flush();
		$this->addReference('stake', $recipe);
	}

	public function loadMilkShake($em)
	{
		$recipe = new Recipe();
		$recipe->setTitle('Pieno kokteilis');
		$recipe->setImg('http://lorempixel.com/250/250/food/');
		$recipe->setDescription('Aprasymas apie Ruosiama recepta! Pats aprasymas nera ilgas.');
		$recipe->setTime(9);
		$em->persist($recipe);
		$em->flush();
		$this->addReference('milkshake', $recipe);
	}


	public function getOrder()
	{
		return 2;
	}

}



 ?>