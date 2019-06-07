<?php

namespace App\Repository;

use App\Entity\Application;
use App\Entity\Value;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Value|null find($id, $lockMode = null, $lockVersion = null)
 * @method Value|null findOneBy(array $criteria, array $orderBy = null)
 * @method Value[]    findAll()
 * @method Value[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValueRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Value::class);
    }

    /**
     * @param Application $application
     * @return Value[]
     */
    public function findApplicationValues(Application $application)
    {
        $qb = $this->createQueryBuilder('v');

        return $qb->select('v', 'env', 'attr')
            ->innerJoin('v.environment', 'env')
            ->innerJoin('v.attribute', 'attr')
            ->where('env.application = :application')
            ->andWhere('attr.application = :application')
            ->setParameter('application', $application)
            ->getQuery()
            ->getResult();
    }
}
