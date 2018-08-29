<?php
namespace App\Service\Cart\Order;


use App\Entity\Item;
use App\Service\Cart\RemoveFromCartInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RemoveFromOrderOrderCart extends OrderCartAbstract implements RemoveFromCartInterface
{

    private  $item ;

    public function __construct(item $item,$entityManager ,$authUser)
    {
        $this->item = $item;
        parent::__construct($entityManager ,$authUser);
    }

    public function remove()
    {
        $cart = $this->cartChecker();

        if (!$cart) {
            // there is no cartApp for this user
            throw new NotFoundHttpException('there is no cart');
        }

        // get cart details
        $cartDetails = $cart->getCartDetails();

    }
}