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

    /**
     * @var SearchQueryBuilder $searchQueryBuilderService
     */
    private $searchQueryBuilderService;

    public function __construct($em) {
        $this->em = $em;
        $this->repository = $em->getRepository('CtsRecipesBundle:Recipe');
    }

    /**
     * @param integer $totalMinutes
     * @param string $products
     * @param string $antiProducts
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
            $searchQueryBuilder = $this->searchQueryBuilderService;
            $recipes = $searchQueryBuilder->getSearchResults($products, $antiProducts, $totalMinutes);
        }
        return $recipes;
    }

    /**
     * @param \Cts\RecipesBundle\Search\SearchQueryBuilder $searchQueryBuilderService
     */
    public function setSearchQueryBuilderService($searchQueryBuilderService)
    {
        $this->searchQueryBuilderService = $searchQueryBuilderService;
    }
} 