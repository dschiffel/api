<?php

namespace App\Repository;

use App\Entity\ReleaseAttribute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ReleaseAttribute|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReleaseAttribute|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReleaseAttribute[]    findAll()
 * @method ReleaseAttribute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReleaseAttributeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ReleaseAttribute::class);
    }

    // /**
    //  * @return ReleaseAttribute[] Returns an array of ReleaseAttribute objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReleaseAttribute
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
