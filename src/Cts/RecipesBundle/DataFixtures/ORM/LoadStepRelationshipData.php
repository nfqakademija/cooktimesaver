<?php 
namespace Cts\RecipesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Cts\RecipesBundle\Entity\StepRelationship;

class LoadStepRelationshipData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $em)
	{
		$this->loadSoup($em);

	}

	public function loadSoup(ObjectManager $em)
	{

		$step_rel = new StepRelationship();
		$step_rel->setRecipeStepId($this->getReference('soupstep5')->getId());
		$step_rel->setParentId(null);
		$em->persist($step_rel);

		$step_rel = new StepRelationship();
		$step_rel->setRecipeStepId($this->getReference('soupstep4')->getId());
		$step_rel->setParentId($this->getReference('soupstep5')->getId());
		$em->persist($step_rel);

		$step_rel = new StepRelationship();
		$step_rel->setRecipeStepId($this->getReference('soupstep3')->getId());
		$step_rel->setParentId($this->getReference('soupstep4')->getId());
		$em->persist($step_rel);

		$step_rel = new StepRelationship();
		$step_rel->setRecipeStepId($this->getReference('soupstep2')->getId());
		$step_rel->setParentId($this->getReference('soupstep3')->getId());
		$em->persist($step_rel);

		$step_rel = new StepRelationship();
		$step_rel->setRecipeStepId($this->getReference('soupstep1')->getId());
		$step_rel->setParentId($this->getReference('soupstep2')->getId());
		$em->persist($step_rel);

		$em->flush();
	}

	public function getOrder()
	{
		return 5;
	}
}


 ?>