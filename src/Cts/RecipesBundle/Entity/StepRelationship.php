<?php 
namespace Cts\RecipesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="recipe_step_relationships")
 */
class StepRelationship

{
    /**
     * @ORM\OneToOne(targetEntity="RecipeStep", inversedBy="step_relationships")
     * @ORM\JoinColumn(name="recipe_step_id", referencedColumnName="id")
     */
    private $recipe_step;

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="integer")
	 */
	protected $recipe_step_id;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $parent_id;

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
     * Set recipe_step_id
     *
     * @param integer $recipeStepId
     * @return step_relationships
     */
    public function setRecipeStepId($recipeStepId)
    {
        $this->recipe_step_id = $recipeStepId;
        return $this;
    }

    /**
     * Get recipe_step_id
     *
     * @return integer 
     */
    public function getRecipeStepId()
    {
        return $this->recipe_step_id;
    }

    /**
     * Set parent_id
     *
     * @param integer $parentId
     * @return step_relationships
     */
    public function setParentId($parentId)
    {
        $this->parent_id = $parentId;
        return $this;
    }

    /**
     * Get parent_id
     *
     * @return integer 
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * Add recipe_step
     *
     * @param \Cts\RecipesBundle\Entity\RecipeStep $recipeStep
     * @return step_relationships
     */
    public function addRecipeStep(\Cts\RecipesBundle\Entity\RecipeStep $recipeStep)
    {
        $this->recipe_step = $recipeStep;
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
