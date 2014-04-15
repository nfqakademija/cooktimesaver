<?php 
namespace Cts\RecipesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Cts\RecipesBundle\Entity\Ingredient;

class LoadIngredientData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$ingredient = new Ingredient();
		$ingredient->setIngredient('Bulves');
		$manager->persist($ingredient);	
		$this->addReference('Bulves', $ingredient);

		$ingredient = new Ingredient();
		$ingredient->setIngredient('Morkos');
		$manager->persist($ingredient);	
		$this->addReference('Morkos', $ingredient);

		$ingredient = new Ingredient();
		$ingredient->setIngredient('Pomidorai');
		$manager->persist($ingredient);	
		$this->addReference('Pomidorai', $ingredient);

		$ingredient = new Ingredient();
		$ingredient->setIngredient('Druskos');
		$manager->persist($ingredient);	
		$this->addReference('Druskos', $ingredient);

		$ingredient = new Ingredient();
		$ingredient->setIngredient('Salieras');
		$manager->persist($ingredient);	
		$this->addReference('Salieras', $ingredient);
		
		$ingredient = new Ingredient();
		$ingredient->setIngredient('Jautiena');
		$manager->persist($ingredient);	
		$this->addReference('Jautiena', $ingredient);

		$ingredient = new Ingredient();
		$ingredient->setIngredient('Pienas');
		$manager->persist($ingredient);	
		$this->addReference('Pienas', $ingredient);

		$ingredient = new Ingredient();
		$ingredient->setIngredient('Avietes');
		$manager->persist($ingredient);	
		$this->addReference('Avietes', $ingredient);

		$manager->flush();
	}

	public function getOrder()
	{
		return 1;
	}
}


 ?>