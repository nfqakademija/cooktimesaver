<?php 
namespace Cts\RecipesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="step_relationships")
 */
class step_relationships

{
    private $recipe_step;

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="integer")
     * @ORM\ManyToMany(targetEntity="recipe_step", mappedBy="step_relationships")
	 */
	protected $recipe_step_id;

	/**
	 * @ORM\Column(type="integer")
     * @ORM\ManyToMany(targetEntity="recipe_step", mappedBy="step_relationships")
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
}
