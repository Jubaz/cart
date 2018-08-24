<?php

namespace App\DataFixtures\ORM;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class LoadUserData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

//        // create 20 user!
//        for ($i = 0; $i < 20; $i++) {
//            $user = new user();
//            $user->setName($faker->name);
//            $user->setEmail($faker->email);
//            $user->setPassword(md5('123456'));
//            $manager->persist($user);
//            $this->setReference('user.reference', $user);
//        }
//        $manager->flush();
    }
}