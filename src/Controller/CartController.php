<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Service\Cart\CartInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/order/cart", name="order.cart")
     * @param CartInterface $cart
     * @return Response
     */
    public function index(CartInterface $cart)
    {
        $cart = $this->getDoctrine()
            ->getRepository(Cart::class)
            ->findOneBy([
                'user' => $this->getUser()
            ]);

        return $this->render('cart/index.html.twig',[
            'cart' => $cart
        ]);
    }

    /**
     * @Route("/addToCart/{itemId}", name="addToCart")
     * @param $itemId
     * @param CartInterface $cart
     * @return string
     */
    public function addToCart($itemId,CartInterface $cart)
    {
        $cart->addToCart($itemId ,1);
        return $this->redirectToRoute('items');
    }


}