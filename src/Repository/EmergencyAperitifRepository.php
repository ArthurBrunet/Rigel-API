<?php

namespace App\Repository;

use App\Entity\EmergencyAperitif;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EmergencyAperitif|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmergencyAperitif|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmergencyAperitif[]    findAll()
 * @method EmergencyAperitif[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmergencyAperitifRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmergencyAperitif::class);
    }

    // /**
    //  * @return EmergencyAperitif[] Returns an array of EmergencyAperitif objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EmergencyAperitif
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
