<?php 
namespace Cts\RecipesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="ingredients")
 */
class ingredient
{
    private $recipe_ingredients_needed;

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @ORM\OneToMany(targetEntity="recipe_ingredients_needed", mappedBy="ingredients_id")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=120)
	 */
	protected $ingredient;

    public function __construct()
    {
        $this->recipe_ingredients_needed = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ingredient
     *
     * @param string $ingredient
     * @return ingredient
     */
    public function setIngredient($ingredient)
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    /**
     * Get ingredient
     *
     * @return string 
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }
}
