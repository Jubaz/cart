<?php
namespace App\Service\Cart;

interface CartInterface
{
    public function addToCart($itemId ,int $quantity);
}