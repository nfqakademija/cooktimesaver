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
     * @ORM\OneToMany(targetEntity="RecipeIngredient", mappedBy="ingredient")
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
     * @return Ingredient
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
     * Add recipe_ingredients
     *
     * @param \Cts\RecipesBundle\Entity\RecipeIngredient $recipeIngredients
     * @return Ingredient
     */
    public function addRecipeIngredient(\Cts\RecipesBundle\Entity\RecipeIngredient $recipeIngredients)
    {
        $this->recipe_ingredients[] = $recipeIngredients;

        return $this;
    }

    /**
     * Remove recipe_ingredients
     *
     * @param \Cts\RecipesBundle\Entity\RecipeIngredient $recipeIngredients
     */
    public function removeRecipeIngredient(\Cts\RecipesBundle\Entity\RecipeIngredient $recipeIngredients)
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
