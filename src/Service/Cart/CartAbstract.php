<?php

namespace App\Service\Cart;


use App\Entity\Cart;
use App\Entity\CartDetails;
use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Security;

abstract class CartAbstract
{
    protected $entityManager;

    protected $security;

    public function __construct(EntityManagerInterface $entityManager ,Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }


    /**
     * check if there is item in database or not
     * @param $itemId
     * @return null|object
     */
    public function ItemChecker($itemId)
    {
        $item = $this->entityManager
            ->getRepository(Item::class)
            ->find($itemId);

        if (!$item) {
            throw new NotFoundHttpException('item not found');
        }

        return $item;
    }


    /**
     * check if there is cart for logged in user or not
     * @return bool|null|object
     */
    public function cartChecker()
    {
        $cart = $this->entityManager
            ->getRepository(Cart::class)->findOneBy([
                'user' => $this->security->getUser()
            ]);

        if (!$cart)
            return false;

        return $cart;
    }

    /**
     * building a new cart details entity
     * @param Item $item
     * @param int $quantity
     * @param Cart|null $cart
     * @return CartDetails
     */
    public function cartDetailsBuilder(Item $item , int $quantity, Cart $cart = null) : CartDetails
    {
        $cartDetails = new CartDetails();
        $cartDetails->setItem($item)
            ->setQuantity($quantity);

        if ($cart)
            $cartDetails->setCart($cart);

        return $cartDetails;
    }
}