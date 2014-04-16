<?php
namespace Cts\RecipesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractBasicData extends AbstractFixture implements ContainerAwareInterface
{
	/**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    protected function getFixtureFile($filename)
    {
    	$kernel = $this->container->get('kernel');
		$path = $kernel->locateResource('@CtsRecipesBundle/DataFixtures/ORM/Data/'.$filename);
		return $path;
    }

    public function getRecipeFixtures($filename)
    {
	   	$row = 1;
	   	$handle = fopen($this->getFixtureFile($filename), "r");
	   	$fixtures = [];
		if ($handle !== FALSE) {
	   		$columnCount = 0;
	   		$keys = [];
		    while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
		    	if ($row ===1 ){
		    		$keys = $data;
		    		$columnCount = count($data);
		    	} elseif ($columnCount == count($data)) {
		    		$fixtures[] = array_combine($keys, $data);
		    	}
		        $row++;
		    }
		    fclose($handle);
		}
		return $fixtures;
    }


}
