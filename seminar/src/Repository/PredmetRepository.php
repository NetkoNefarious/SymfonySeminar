<?php

namespace App\Repository;

use App\Entity\Predmet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Predmet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Predmet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Predmet[]    findAll()
 * @method Predmet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PredmetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Predmet::class);
    }

    public function findAllAndOrderByStatus($status)
    {
        $orderByStatus = "p.semRedovni";
        if (strcasecmp($status, "izvanredni") === 0) {
            $orderByStatus = "p.semIzvanredni";
        }
        return $this->createQueryBuilder('p')
            ->orderBy($orderByStatus, 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Predmet[] Returns an array of Predmet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Predmet
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
