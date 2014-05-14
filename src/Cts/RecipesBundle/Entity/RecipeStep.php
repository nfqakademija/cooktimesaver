<?php 
namespace Cts\RecipesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="recipe_steps")
 */
class RecipeStep
{
    /**
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="recipe_step")
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
     */
    private $recipe;

    /**
     * @ORM\OneToOne(targetEntity="StepRelationship", mappedBy="recipe_step")
     */
    private $step_relationships;

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
	 * @ORM\Column(type="bigint")
	 */
	protected $total_time;

	/**
	 * @ORM\Column(type="text")
	 */
	protected $description;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	protected $image;

	/**
	 * @ORM\Column(type="integer")
	 */
	protected $total_time_count;

	/**
	 * @ORM\Column(type="smallint")
	 */
	protected $type;


    public function __construct()
    {
        $this->recipe = new ArrayCollection();
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
     * @return RecipeStep
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
     * Set total_time
     *
     * @param integer $totalTime
     * @return RecipeStep
     */
    public function setTotalTime($totalTime)
    {
        $this->total_time = $totalTime;

        return $this;
    }

    /**
     * Get total_time
     *
     * @return integer 
     */
    public function getTotalTime()
    {
        return $this->total_time;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return RecipeStep
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
     * Set image
     *
     * @param string $image
     * @return RecipeStep
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set total_time_count
     *
     * @param integer $totalTimeCount
     * @return RecipeStep
     */
    public function setTotalTimeCount($totalTimeCount)
    {
        $this->total_time_count = $totalTimeCount;

        return $this;
    }

    /**
     * Get total_time_count
     *
     * @return integer 
     */
    public function getTotalTimeCount()
    {
        return $this->total_time_count;
    }

    /**
     * Set type
     *
     * @param \smallint $type
     * @return RecipeStep
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set recipe
     *
     * @param \Cts\RecipesBundle\Entity\recipe $recipe
     * @return RecipeStep
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
     * Set step_relationships
     *
     * @param \Cts\RecipesBundle\Entity\StepRelationship $stepRelationships
     * @return RecipeStep
     */
    public function setStepRelationships(\Cts\RecipesBundle\Entity\StepRelationship $stepRelationships = null)
    {
        $this->step_relationships = $stepRelationships;

        return $this;
    }

    /**
     * Get StepRelationship
     *
     * @return \Cts\RecipesBundle\Entity\StepRelationship 
     */
    public function getStepRelationships()
    {
        return $this->step_relationships;
    }
}
