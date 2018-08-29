<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Item;
use App\Service\Cart\CartApp;
use App\Service\Cart\CartInterface;
use App\Service\Cart\Order\AddToOrderOrderCart;
use App\Service\Cart\WishList\AddToWishListCart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class CartController extends AbstractController
{
    /**
     * @Route("/order/cartApp", name="order.cart")
     * @return Response
     */
    public function index()
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
     * @Route("/addToCart/{id}", name="addToCart")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Item $item
     * @param cartApp $cartApp
     * @param EntityManagerInterface $entityManager
     * @return string
     */
    public function addToOrderCart(item $item, CartApp $cartApp ,EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        $cartApp->addToCart(new AddToOrderOrderCart($item,$entityManager,$user));
        return $this->redirectToRoute('order.cart');
    }


    /**
     * @Route("/addToWishList/{id}", name="addToWishList")
     * @param $itemId
     * @param CartApp $cart
     * @return string
     */
    public function addToWishListCart($itemId,CartApp $cart)
    {
        $cart->addToCart(new AddToWishListCart($itemId));
        return $this->redirectToRoute('items');
    }

    /**
     * @Route("/test", name="test")
     * @return string
     */
    public function test()
    {
        $session = new Session();
        dump($session->get('wishList'));
        die();
    }

}