<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    private $findArticlesQueryBuilder;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

// =============   06/10/2020 1.53 !!!! ==========================

    /**
     * @param int $id
     * @return int|mixed|string
     */
    public function findByCategoryId(int $id)
    {
        $qb = $this
            ->createQueryBuilder('a')
            ->innerJoin('a.categories', 'categories')
            ->andWhere('categories.id = :val')
            ->setParameter('val', $id)
        ;
        return $qb
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return QueryBuilder
     */
    public function findArticlesQueryBuilder(): QueryBuilder
    {
        return $this
            ->createQueryBuilder('article')
            ->orderBy('article.createdAt', 'DESC')
            ;
    }




    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
