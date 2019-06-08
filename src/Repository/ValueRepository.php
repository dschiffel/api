<?php

namespace App\Repository;

use App\Entity\Attribute;
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
     * @param Attribute $attribute
     * @return Value[]
     */
    public function findValuesForAttribute(Attribute $attribute)
    {
        $qb = $this->createQueryBuilder('v');

        return $qb->select('v', 'attr', 'env')
            ->innerJoin('v.environment', 'env')
            ->innerJoin('v.attribute', 'attr')
            ->where('attr = :attribute')
            ->setParameter('attribute', $attribute)
            ->getQuery()
            ->getResult();
    }
}
