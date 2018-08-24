<?php

namespace App\Repository;

use App\Entity\CartDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CartDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method CartDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method CartDetails[]    findAll()
 * @method CartDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartDetailsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CartDetails::class);
    }

    public function updateQuantity($cartDetails ,int $quantity)
    {
        return $this ->createQueryBuilder('c')
            ->update($this->getEntityName(), 'c')
            ->set('f.quantity', $cartDetails->getQuantity() + $quantity)
            ->where('f.id = :id')->setParameter('id', $cartDetails->getId())
            ->getQuery()
            ->execute();
    }

}
