<?php 
namespace Cts\RecipesBundle\Services;

class Recipe
{
	protected $time;
	protected $ingredients;
	protected $about;

	/**
	 * @param mixed $about
	 */
	public function setAbout($about)
	{
		$this->about = $about;
	}

	/**
	 * @param mixed $ingredients
	 */
	public function setIngredients($ingredients)
	{
		$this->ingredients = $ingredients;
	}

	/**
	 * @param mixed $time
	 */
	public function setTime($time)
	{
		$this->time = $time;
	}

	/**
	 * @return mixed
	 */
	public function getAbout()
	{
		return $this->about;
	}

	/**
	 * @return mixed
	 */
	public function getIngredients()
	{
		return $this->ingredients;
	}

	/**
	 * @return mixed
	 */
	public function getTime()
	{
		return $this->time;
	}
}
