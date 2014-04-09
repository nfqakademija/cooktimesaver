<?php

namespace Cts\RecipesBundle\Services;


class CollectionRecipe {

	protected $collection = [];

	protected $rootDir;

	public function setFixtureFile($file)
	{
		$content = file_get_contents($file);
		$content = json_decode($content);
		foreach ($content as $item) {
			$recipe = new Recipe();
			$recipe->setAbout($item->about);
			$recipe->setTime($item->time);
			$recipe->setIngredients($item->ingridients);
			$this->collection[] = $recipe;
		}
	}

	public function getRecipes()
	{
		return $this->collection;
	}

	/**
	 * @param mixed $rootDir
	 */
	public function setRootDir($rootDir)
	{
		$this->rootDir = $rootDir;
	}
}