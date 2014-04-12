<?php 
namespace Cts\RecipesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="recipe_ingredients_needed")
 */
class recipe_ingredients_needed
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="integer")
	 */
	protected $recipe_id;

	/**
	 * @ORM\Column(type="integer")
	 */
	protected $ingredients_id;

	/**
	 * @ORM\Column(type="string")
	 */
	protected $amount;

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
     * Set recipe_id
     *
     * @param integer $recipeId
     * @return recipe_ingredients_needed
     */
    public function setRecipeId($recipeId)
    {
        $this->recipe_id = $recipeId;

        return $this;
    }

    /**
     * Get recipe_id
     *
     * @return integer 
     */
    public function getRecipeId()
    {
        return $this->recipe_id;
    }

    /**
     * Set ingredients_id
     *
     * @param integer $ingredientsId
     * @return recipe_ingredients_needed
     */
    public function setIngredientsId($ingredientsId)
    {
        $this->ingredients_id = $ingredientsId;

        return $this;
    }

    /**
     * Get ingredients_id
     *
     * @return integer 
     */
    public function getIngredientsId()
    {
        return $this->ingredients_id;
    }

    /**
     * Set amount
     *
     * @param string $amount
     * @return recipe_ingredients_needed
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string 
     */
    public function getAmount()
    {
        return $this->amount;
    }
}
