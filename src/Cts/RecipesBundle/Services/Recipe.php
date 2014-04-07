<?php 
namespace Cts\RecipesBundle\Services;

class Recipe
{
	protected $time;
	protected $ingredients;
	protected $about;

	public function __construct($time, $ingredients, $about)
	{
		$this->time        = $time;
		$this->ingredients = $ingredients;
		$this->about       = $about;
	}

	public function getTime()
	{
		return $this->time;
	}

	public function getIng()
	{
		return $this->ingredients;
	}

	public function getAbout()
	{
		return $this->about;
	}

}


 ?>