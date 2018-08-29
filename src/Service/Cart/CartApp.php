<?php

namespace App\Service\Cart;


class CartApp
{
    public function addToCart(AddToCartInterface $cart)
    {
        return $cart->add();
    }

    public function removeFromCart(RemoveFromCartInterface $cart)
    {
        return $cart->remove();
    }

}