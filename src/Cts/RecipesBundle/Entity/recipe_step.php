<?php 
namespace Cts\RecipesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="recipe_step")
 */
class recipe_step
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
	 * @ORM\Column(type="tinyint")
	 */
	protected $type;


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
     * @return recipe_step
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
     * @return recipe_step
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
     * @return recipe_step
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
     * @return recipe_step
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
     * @return recipe_step
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
     * @param \tinyint $type
     * @return recipe_step
     */
    public function setType(\tinyint $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \tinyint 
     */
    public function getType()
    {
        return $this->type;
    }
}
