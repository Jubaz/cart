<?php

namespace App\Service\Cart;


use App\Entity\Cart;
use App\Entity\CartDetails;
use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class OrderCart extends CartAbstract implements CartInterface
{

    public function __construct(EntityManagerInterface $entityManager ,Security $security)
    {
        parent::__construct($entityManager , $security);
    }

    public function addToCart($itemId ,int $quantity)
    {
        $item = $this->ItemChecker($itemId);

        // check if there is cart for this user or not

        $cart = $this->cartChecker();

        if (!$cart) {
            // there is no cart for this user let's add one with item
            $this->addNewCart($item,$quantity);
        }

        // get the same item
        $cartDetails = $cart->getCartDetails()->filter(
            function (CartDetails $details) use ($item) {
                return $details->getItem()->getId() == $item->getId();
            }
        );

        if ($cartDetails->isEmpty()){
            $this->addNewItem($item,$cart,1);
        }

        $this->updateQuantity($cartDetails,2);
    }


    /**
     * @param Item $item
     * @param int $quantity
     */
    private function addNewCart(Item $item , int $quantity)
    {
        // building cart details entity
        $cartDetails = $this->cartDetailsBuilder($item,$quantity);

        // building cart entity
        $cart = new Cart();
        $cart->setTotalPrice($item->getPrice())
            ->setUser($this->security->getUser())
            ->addCartDetail($cartDetails);

        $this->entityManager->persist($cartDetails);
        $this->entityManager->persist($cart);
        $this->entityManager->flush();
    }

    private function addNewItem(Item $item, Cart $cart, int $quantity)
    {
        $cartDetails = $this->cartDetailsBuilder($item,$quantity,$cart);
        $this->entityManager->persist($cartDetails);
        $this->entityManager->flush();
    }

    private function updateQuantity($cartDetails ,$quantity)
    {
        foreach ($cartDetails as $detail) {
            $detail->setQuantity($detail->getQuantity() + $quantity);
            $this->entityManager->persist($detail);
        }
        $this->entityManager->flush();
    }



}