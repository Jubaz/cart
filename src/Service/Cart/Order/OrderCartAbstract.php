<?php

namespace App\Service\Cart\Order;


use App\Entity\Cart;
use App\Entity\CartDetails;
use App\Entity\Item;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class OrderCartAbstract
{
    protected $entityManager;

    protected $authUser;

    public function __construct($entityManager ,$authUser)
    {
        $this->entityManager = $entityManager;
        $this->authUser = $authUser;
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
     * check if there is cartApp for logged in user or not
     * @return bool|null|object
     */
    public function cartChecker()
    {
        $cart = $this->entityManager
            ->getRepository(Cart::class)->findOneBy([
                'user' => $this->security
            ]);

        if (!$cart)
            return false;

        return $cart;
    }

    /**
     * building a new cartApp details entity
     * @param Item $item
     * @param int $quantity
     * @param Cart $cart
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