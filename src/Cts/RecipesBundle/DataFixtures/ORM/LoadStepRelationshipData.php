<?php 
namespace Cts\RecipesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Cts\RecipesBundle\Entity\StepRelationship;

class LoadStepRelationshipData extends AbstractBasicData implements OrderedFixtureInterface
{
	public function load(ObjectManager $em)
	{
        $stepsRel = $this->getRecipeFixtures('steps_relationship.csv');

        foreach ($stepsRel as $item) {
            $stepRelationship = new StepRelationship();
            $recipeStep       = $this->getReference($item['STEP']);

            if($item['PARENT'] != 'null'){
                $parentId = $this->getReference($item['PARENT'])->getId();
            } else {
                $parentId = null;
            }
            $stepRelationship->setRecipeStepId($recipeStep->getId());
            $stepRelationship->setParentId($parentId);
            $stepRelationship->addRecipeStep($recipeStep);

            $em->persist($stepRelationship);
            $em->flush();
        }
	}

	public function getOrder()
	{
		return 5;
	}
}
