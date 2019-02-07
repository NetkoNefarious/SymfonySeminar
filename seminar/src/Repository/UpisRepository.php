<?php

namespace App\Repository;

use App\Entity\Upis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Upis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Upis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Upis[]    findAll()
 * @method Upis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UpisRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Upis::class);
    }

    // /**
    //  * @return Upis[] Returns an array of Upis objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Upis
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
