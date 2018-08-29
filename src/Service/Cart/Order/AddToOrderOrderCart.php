<?php
namespace App\Service\Cart\Order;


use App\Entity\Cart;
use App\Entity\CartDetails;
use App\Entity\Item;
use App\Service\Cart\AddToCartInterface;


class AddToOrderOrderCart extends OrderCartAbstract implements AddToCartInterface
{

    private  $item ;

    private $quantity = 1;

    public function __construct(item $item,$entityManager ,$security)
    {
        $this->item = $item;
        parent::__construct($entityManager , $security);
    }

    public function add()
    {
        // check if there is cartApp for this user or not
        $cart = $this->cartChecker();

        if (!$cart) {
            // there is no cartApp for this user let's add one with item
            $this->addNewCart($this->item,$this->quantity);
        }
        $item = $this->item;


        // get the same item
        $cartDetails = $cart->getCartDetails()->filter(
            function (CartDetails $details) use ($item) {
                return $details->getItem()->getId() == $item->getId();
            }
        );

        if ($cartDetails->isEmpty()){
            $this->addNewItem($item,$cart,$this->quantity);
        }

        $this->updateQuantity($cartDetails,2);
    }


    /**
     * @param Item $item
     * @param int $quantity
     */
    private function addNewCart(Item $item , int $quantity)
    {
        // building cartApp details entity
        $cartDetails = $this->cartDetailsBuilder($item,$quantity);

        // building cartApp entity
        $cart = new Cart();
        $cart->setTotalPrice($item->getPrice())
            ->setUser($this->security)
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