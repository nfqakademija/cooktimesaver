<?php
/**
 * Created by PhpStorm.
 * User: Rolandas
 * Date: 5/13/14
 * Time: 7:34 PM
 */

namespace Cts\RecipesBundle\Search;

use Doctrine\ORM\EntityManager;

class SearchQueryBuilder {

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var array
     */
    private $products;

    /**
     * @var array
     */
    private $antiProducts;

    /**
     * @var integer
     */
    private $totalMinutes;

    public function __construct($em, $products, $antiProducts, $totalMinutes)
    {
        $this->em = $em;
        $this->products = $products;
        $this->antiProducts = $antiProducts;
        $this->totalMinutes = $totalMinutes;
    }

    public function getSearchResults(){
        if (empty($this->products) && !empty($this->antiProducts)) {
            $statement = $this->em->getConnection()->prepare("  SELECT r.*, SUM(ri.ingredients_id NOT IN (". $this->preparePlaceHolders($this->antiProducts) .")) as inverse_ing_match_count, COUNT(*) as recipe_ing_count
                                                                FROM recipes r
                                                                JOIN recipe_ingredients_needed ri
                                                                ON ri.recipe_id = r.id
                                                                WHERE r.time < ?
                                                                GROUP BY r.id
                                                                HAVING inverse_ing_match_count = recipe_ing_count
                                                                ORDER BY r.time ASC");
            $items = array_merge((array)$this->antiProducts, (array)$this->totalMinutes);
        } else {
            $statement = $this->em->getConnection()->prepare("  SELECT r.*, SUM(ri.ingredients_id IN (". $this->preparePlaceHolders($this->products) .")) as ing_match_count, COUNT(*) as recipe_ing_count
                                                                FROM recipes r
                                                                JOIN recipe_ingredients_needed ri
                                                                ON ri.recipe_id = r.id
                                                                WHERE r.time < ?
                                                                GROUP BY r.id
                                                                HAVING ing_match_count > 0 AND SUM(ri.ingredients_id in (". $this->preparePlaceHolders($this->antiProducts) .")) = 0
                                                                ORDER BY ing_match_count DESC, r.time ASC");
            $items = array_merge((array)$this->products, (array)$this->totalMinutes, (array)$this->antiProducts);
        }
        $this->setValues($items, $statement);
        $statement->execute();
        $recipes = $statement->fetchAll();
        return $recipes;
    }

    private function preparePlaceHolders($items){
        $length = count($items);
        if ($length > 0) {
            $placeHolders = str_repeat('?,', $length - 1) . '?';
        } else {
            $placeHolders = 0;
        }
        return $placeHolders;
    }

    private function setValues($items, &$statement){
        foreach ($items as $k => $id){
            $statement->bindValue($k+1, $id);
        }
    }
} 