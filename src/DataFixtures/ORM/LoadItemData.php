<?php

namespace App\DataFixtures\ORM;

use App\Entity\Item;
use App\Entity\ItemPhysical;
use App\Entity\ItemSale;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class LoadItemData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        // create 20 sale item!
        for ($i = 0; $i < 20; $i++) {

            $itemSale = new ItemSale();
            $itemSale->setExpireDate($faker->dateTime());
            $itemSale->setStartDate($faker->dateTime());

            $item = new item();
            $item->setTitle($faker->words('3',true));
            $item->setPrice($faker->randomNumber(4));
            $item->setType('sale');
            $item->setItemSale($itemSale);

            $manager->persist($item);
        }

        // create 20 physical item!
        for ($i = 0; $i < 20; $i++) {

            $ItemPhysical = new ItemPhysical();
            $ItemPhysical->setWeight($faker->randomNumber('2').' KG');

            $item = new item();
            $item->setTitle($faker->words('3',true));
            $item->setPrice($faker->randomNumber(4));
            $item->setType('physical');
            $item->setItemPhysical($ItemPhysical);

            $manager->persist($item);
        }
        $manager->flush();
    }
}