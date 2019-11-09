<?php

namespace App\Repository;

use App\Entity\Deploy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Deploy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Deploy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Deploy[]    findAll()
 * @method Deploy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeployRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Deploy::class);
    }
}
