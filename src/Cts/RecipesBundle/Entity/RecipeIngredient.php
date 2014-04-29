<?php 
namespace Cts\RecipesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="recipe_ingredients_needed")
 */
class RecipeIngredient
{
    /**
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="recipe_ingredients")
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
     */
    private $recipe;
    
    /**
     * @ORM\ManyToOne(targetEntity="Ingredient", inversedBy="recipe_ingredients")
     * @ORM\JoinColumn(name="ingredients_id", referencedColumnName="id")
     */
    private $ingredient;

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


    public function __construct()
    {
        $this->recipe     = new ArrayCollection();
        $this->ingredient = new ArrayCollection();
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

    /**
     * Set recipe
     *
     * @param \Cts\RecipesBundle\Entity\recipe $recipe
     * @return recipe_ingredients_needed
     */
    public function setRecipe(\Cts\RecipesBundle\Entity\recipe $recipe = null)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get recipe
     *
     * @return \Cts\RecipesBundle\Entity\recipe 
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Set ingredient
     *
     * @param \Cts\RecipesBundle\Entity\ingredient $ingredient
     * @return recipe_ingredients_needed
     */
    public function setIngredient(\Cts\RecipesBundle\Entity\ingredient $ingredient = null)
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    /**
     * Get ingredient
     *
     * @return \Cts\RecipesBundle\Entity\ingredient 
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }
}
