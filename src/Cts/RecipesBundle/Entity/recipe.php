<?php 
namespace Cts\RecipesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="recipe")
 */

class recipe
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=200)
	 */
	protected $title;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	protected $img;

	/**
	 * @ORM\Column(type="text")
	 */
	protected $description;

	/**
	 * @ORM\Column(type="integer")
	 */
	protected $time;
}

 ?>