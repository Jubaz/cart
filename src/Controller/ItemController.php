<?php

namespace App\Controller;

use App\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    /**
     * @Route("/items", name="items")
     */
    public function index()
    {
        $items = $this->getDoctrine()
            ->getRepository(Item::class)
            ->findAll();

        return $this->render('item/index.html.twig',[
            'items' => $items
        ]);
    }

}