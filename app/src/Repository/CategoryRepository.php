<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function queryAll():QueryBuilder
    {
        return $this->getOrCreateQueryBuilder();
    }

    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null):QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('category');
    }
}
