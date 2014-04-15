<?php 
namespace Cts\RecipesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="recipes")
 */

class Recipe
{
	/**
	 * @ORM\OneToMany(targetEntity="RecipeIngredient", mappedBy="recipe")
	 */
	private $recipe_ingredients;

	/**
	 * @ORM\OneToMany(targetEntity="RecipeStep", mappedBy="recipe")
	 */
	private $recipe_step;

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


	public function __construct()
	{
		$this->recipe_ingredients = new ArrayCollection();
		$this->recipe_step = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return recipe
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set img
     *
     * @param string $img
     * @return recipe
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string 
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return recipe
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set time
     *
     * @param integer $time
     * @return recipe
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return integer 
     */
    public function getTime()
    {
        return $this->time;
    }


    /**
     * Add recipe_ingredients
     *
     * @param \Cts\RecipesBundle\Entity\RecipeIngredient $recipeIngredients
     * @return Recipe
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

    /**
     * Add recipe_step
     *
     * @param \Cts\RecipesBundle\Entity\RecipeStep $recipeStep
     * @return Recipe
     */
    public function addRecipeStep(\Cts\RecipesBundle\Entity\RecipeStep $recipeStep)
    {
        $this->recipe_step[] = $recipeStep;

        return $this;
    }

    /**
     * Remove recipe_step
     *
     * @param \Cts\RecipesBundle\Entity\RecipeStep $recipeStep
     */
    public function removeRecipeStep(\Cts\RecipesBundle\Entity\RecipeStep $recipeStep)
    {
        $this->recipe_step->removeElement($recipeStep);
    }

    /**
     * Get recipe_step
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecipeStep()
    {
        return $this->recipe_step;
    }
}
