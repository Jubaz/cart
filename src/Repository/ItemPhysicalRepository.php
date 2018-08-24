<?php

namespace App\Repository;

use App\Entity\ItemPhysical;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ItemPhysical|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemPhysical|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemPhysical[]    findAll()
 * @method ItemPhysical[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemPhysicalRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ItemPhysical::class);
    }
}
