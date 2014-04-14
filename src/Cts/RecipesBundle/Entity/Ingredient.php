<?php 
namespace Cts\RecipesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="ingredients")
 */
class Ingredient
{
    /**
     * @ORM\OneToMany(targetEntity="RecipeIngredient", mappedBy="ingredients_id")
     */
    private $recipe_ingredients;

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
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

    /**
     * Add recipe_ingredients_needed
     *
     * @param \Cts\RecipesBundle\Entity\recipe_ingredients_needed $recipeIngredientsNeeded
     * @return ingredient
     */
    public function addRecipeIngredientsNeeded(\Cts\RecipesBundle\Entity\recipe_ingredients_needed $recipeIngredientsNeeded)
    {
        $this->recipe_ingredients_needed[] = $recipeIngredientsNeeded;

        return $this;
    }

    /**
     * Remove recipe_ingredients_needed
     *
     * @param \Cts\RecipesBundle\Entity\recipe_ingredients_needed $recipeIngredientsNeeded
     */
    public function removeRecipeIngredientsNeeded(\Cts\RecipesBundle\Entity\recipe_ingredients_needed $recipeIngredientsNeeded)
    {
        $this->recipe_ingredients_needed->removeElement($recipeIngredientsNeeded);
    }

    /**
     * Get recipe_ingredients_needed
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecipeIngredientsNeeded()
    {
        return $this->recipe_ingredients_needed;
    }

    /**
     * Add recipe_ingredients
     *
     * @param \Cts\RecipesBundle\Entity\RecipeIngredients $recipeIngredients
     * @return Ingredient
     */
    public function addRecipeIngredient(\Cts\RecipesBundle\Entity\RecipeIngredients $recipeIngredients)
    {
        $this->recipe_ingredients[] = $recipeIngredients;

        return $this;
    }

    /**
     * Remove recipe_ingredients
     *
     * @param \Cts\RecipesBundle\Entity\RecipeIngredients $recipeIngredients
     */
    public function removeRecipeIngredient(\Cts\RecipesBundle\Entity\RecipeIngredients $recipeIngredients)
    {
        $this->recipe_ingredients->removeElement($recipeIngredients);
    }

    /**
     * Get recipe_ingredients
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecipeIngredients()
    {
        return $this->recipe_ingredients;
    }
}
