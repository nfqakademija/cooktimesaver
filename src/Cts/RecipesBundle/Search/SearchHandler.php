<?php

namespace Cts\RecipesBundle\Search;

use Doctrine\ORM\EntityManager;

class SearchHandler {

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct($em) {
        $this->em = $em;
        $this->repository = $em->getRepository('CtsRecipesBundle:Recipe');
    }

    /**
     * @param integer $totalMinutes
     * @param array $products
     * @param array $antiProducts
     * @return array
     */
    public function search($totalMinutes, $products, $antiProducts)
    {
        if (!empty($products)) {
            $products = explode(",", $products);
        } else {
            $products = [];
        }

        if (!empty($antiProducts)) {
            $antiProducts = explode(",", $antiProducts);
        } else {
            $antiProducts = [];
        }

        if(empty($products) && empty($antiProducts)){
            $query = $this->repository->createQueryBuilder('recipe')
                ->where('recipe.time < :time')
                ->setParameter('time', $totalMinutes)
                ->orderBy('recipe.time', 'ASC')
                ->getQuery();
            $recipes = $query->getResult();

        } else {

            $connection = $this->em->getConnection();

            if(count($antiProducts) > 0){
                $antiProductsQuestionMarks = str_repeat('?,', count($antiProducts) - 1) . '?';
            } else {
                $antiProductsQuestionMarks = '0';
            }
            $position = 0;

            if(empty($products) && !empty($antiProducts)){
                $statement = $connection->prepare("SELECT r.*, SUM(ri.ingredients_id NOT IN (". $antiProductsQuestionMarks .")) as inverse_ing_match_count, COUNT(*) as recipe_ing_count
                                                    FROM recipes r
                                                    JOIN recipe_ingredients_needed ri
                                                    ON ri.recipe_id = r.id
                                                    WHERE r.time < ?
                                                    GROUP BY r.id
                                                    HAVING inverse_ing_match_count = recipe_ing_count
                                                    ORDER BY r.time ASC");
                if(is_array($antiProducts)){
                    foreach ($antiProducts as $k => $id){
                        $position = $k+1;
                        $statement->bindValue(($position), $id);
                    }
                }
                $position = $position +1;
                $statement->bindValue($position, $totalMinutes);
                $statement->execute();
                $recipes = $statement->fetchAll();

            } else {
                $productsQuestionMarks     = str_repeat('?,', count($products) - 1) . '?';
                $statement = $connection->prepare("SELECT r.*,
                                                           SUM(ri.ingredients_id IN (". $productsQuestionMarks .")) as ing_match_count,
                                                           COUNT(*) as recipe_ing_count
                                                    FROM recipes r
                                                    JOIN recipe_ingredients_needed ri
                                                    ON ri.recipe_id = r.id
                                                    WHERE r.time < ?
                                                    GROUP BY r.id
                                                    HAVING ing_match_count > 0 AND SUM(ri.ingredients_id in (". $antiProductsQuestionMarks .")) = 0
                                                    ORDER BY ing_match_count DESC, r.time ASC");
                if(is_array($products)){
                    foreach ($products as $k => $id){
                        $position = $k+1;
                        $statement->bindValue(($position), $id);
                    }
                }
                $position = $position +1;
                $statement->bindValue($position, $totalMinutes);
                foreach ($antiProducts as $k => $id){
                    $statement->bindValue(($position+$k+1), $id);
                }
                $statement->execute();
                $recipes = $statement->fetchAll();
            }
        }
        return $recipes;
    }

} 