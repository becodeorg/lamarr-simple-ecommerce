<?php

namespace App\Repository;

use App\Entity\ShoppingLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShoppingLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShoppingLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShoppingLine[]    findAll()
 * @method ShoppingLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoppingLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShoppingLine::class);
    }

    // /**
    //  * @return ShoppingLine[] Returns an array of ShoppingLine objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ShoppingLine
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
