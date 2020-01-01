<?php

namespace App\Repository;

use App\Entity\ActionToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ActionToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActionToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActionToken[]    findAll()
 * @method ActionToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActionTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActionToken::class);
    }

    // /**
    //  * @return ActionToken[] Returns an array of ActionToken objects
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
    public function findOneBySomeField($value): ?ActionToken
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
