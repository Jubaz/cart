<?php
namespace App\Service\Cart\WishList;

use Symfony\Component\HttpFoundation\Session\Session;


use App\Service\Cart\AddToCartInterface;
use Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage;

class AddToWishListCart implements AddToCartInterface
{

    private $itemId;

    public function __construct(in $itemId)
    {
        $this->itemId = $itemId;
    }

    public function add()
    {

        // Get Symfony to interface with this existing session
        $session = new Session(new PhpBridgeSessionStorage());
        $session->start();

        $wishList = $session->get('wishList');

        if (is_array($wishList)){
            array_push($wishList,$this->itemId);
            // remove duplicate
            $wishList = array_unique($wishList);
            return $session->set('wishList',$wishList);
        }

        return $session->set('wishList',array($itemId));
    }
}