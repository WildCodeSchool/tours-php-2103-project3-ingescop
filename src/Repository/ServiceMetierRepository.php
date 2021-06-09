<?php

namespace App\Repository;

use App\Entity\ServiceMetier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ServiceMetier|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceMetier|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceMetier[]    findAll()
 * @method ServiceMetier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceMetierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceMetier::class);
    }

    // /**
    //  * @return ServiceMetier[] Returns an array of ServiceMetier objects
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
    public function findOneBySomeField($value): ?ServiceMetier
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
