<?php

namespace App\Repository;

use App\Entity\CustomerJob;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CustomerJob|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerJob|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerJob[]    findAll()
 * @method CustomerJob[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerJobRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CustomerJob::class);
    }

//    /**
//     * @return CustomerJob[] Returns an array of CustomerJob objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CustomerJob
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
