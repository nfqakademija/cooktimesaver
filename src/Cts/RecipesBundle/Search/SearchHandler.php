<?php

namespace Cts\RecipesBundle\Search;

use Doctrine\ORM\EntityManager;

class SearchHandler {

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
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
     * @param integer $sum_minutes
     * @param array $products
     * @param array $antiProducts
     * @return array
     */
    public function search($sum_minutes, $products = null, $antiProducts = null){

        if(empty($products[0]) && empty($antiProducts[0])){
            $query = $this->repository->createQueryBuilder('recipe')
                ->where('recipe.time < :time')
                ->setParameter('time', $sum_minutes)
                ->orderBy('recipe.time', 'ASC')
                ->getQuery();
            $recipes = $query->getResult();

        } else{

            $connection = $this->em->getConnection();

            $productsQuestionMarks     = str_repeat('?,', count($products) - 1) . '?';
            $antiProductsQuestionMarks = str_repeat('?,', count($antiProducts) - 1) . '?';

            if(empty($products[0]) && !empty($antiProducts[0])){

                $statement = $connection->prepare("SELECT r.*, SUM(ri.ingredients_id NOT IN (". $antiProductsQuestionMarks .")) as inverse_ing_match_count, COUNT(*) as recipe_ing_count
                                                    FROM recipes r
                                                    JOIN recipe_ingredients_needed ri
                                                    ON ri.recipe_id = r.id
                                                    WHERE r.time < ?
                                                    GROUP BY r.id
                                                    HAVING inverse_ing_match_count = recipe_ing_count
                                                    ORDER BY r.time ASC");

                $position = 1;
                $statement->bindValue($position, $sum_minutes);
                foreach ($antiProducts as $k => $id){
                    $statement->bindValue(($position+$k+1), $id);
                }
                $statement->execute();
                $recipes = $statement->fetchAll();

            } else {

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
                foreach ($products as $k => $id){
                    $position = $k+1;
                    $statement->bindValue(($position), $id);
                }
                $position = $position +1;
                $statement->bindValue($position, $sum_minutes);
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