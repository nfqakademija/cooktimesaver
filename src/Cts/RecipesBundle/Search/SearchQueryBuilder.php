<?php

namespace Cts\RecipesBundle\Search;

use Doctrine\ORM\EntityManager;

class SearchQueryBuilder {

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param $em EntityManager
     */
    public function __construct($em)
    {
        $this->em = $em;
    }

    /**
     * @param array $products
     * @param array $antiProducts
     * @param integer $totalMinutes
     * @return array
     */
    public function getSearchResults($products, $antiProducts, $totalMinutes){

        $statement = $this->em->getConnection()->prepare($this->buildQuery($products, $antiProducts));

        if (empty($products) && !empty($antiProducts)) {
            $items = array_merge((array)$antiProducts, (array)$totalMinutes);
        } else {
            $items = array_merge((array)$products, (array)$totalMinutes, (array)$antiProducts);
        }
        $this->setValues($items, $statement);
        $statement->execute();
        $recipes = $statement->fetchAll();
        return $recipes;
    }

    /**
     * @param array $products
     * @param array $antiProducts
     * @return string
     */
    private function buildQuery($products, $antiProducts){
        if(empty($products) && !empty($antiProducts)) {
            $query =   "SELECT r.*, SUM(ri.ingredients_id NOT IN (". $this->preparePlaceHolders($antiProducts) .")) as inverse_ing_match_count, COUNT(*) as recipe_ing_count
                        FROM recipes r
                        JOIN recipe_ingredients_needed ri
                        ON ri.recipe_id = r.id
                        WHERE r.time < ?
                        GROUP BY r.id
                        HAVING inverse_ing_match_count = recipe_ing_count
                        ORDER BY r.time ASC";
        }
        else {
            $query =   "SELECT r.*, SUM(ri.ingredients_id IN (". $this->preparePlaceHolders($products) .")) as ing_match_count, COUNT(*) as recipe_ing_count
                        FROM recipes r
                        JOIN recipe_ingredients_needed ri
                        ON ri.recipe_id = r.id
                        WHERE r.time < ?
                        GROUP BY r.id
                        HAVING ing_match_count > 0 AND SUM(ri.ingredients_id in (". $this->preparePlaceHolders($antiProducts) .")) = 0
                        ORDER BY ing_match_count DESC, r.time ASC";
        }
        return $query;
    }

    /**
     * @param array $items
     * @return int|string
     */
    private function preparePlaceHolders($items){
        $length = count($items);
        if ($length > 0) {
            $placeHolders = str_repeat('?,', $length - 1) . '?';
        } else {
            $placeHolders = 0;
        }
        return $placeHolders;
    }

    /**
     * @param array $items
     * @param \Doctrine\DBAL\Driver\Statement $statement
     */
    private function setValues($items, &$statement){
        foreach ($items as $k => $id){
            $statement->bindValue($k+1, $id);
        }
    }
} 