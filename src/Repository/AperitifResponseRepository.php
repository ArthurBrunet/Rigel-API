<?php

namespace App\Repository;

use App\Entity\AperitifResponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AperitifResponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method AperitifResponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method AperitifResponse[]    findAll()
 * @method AperitifResponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AperitifResponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AperitifResponse::class);
    }

    // /**
    //  * @return AperitifResponse[] Returns an array of AperitifResponse objects
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
    public function findOneBySomeField($value): ?AperitifResponse
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
