<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        UserFactory::new()->createMany(5);
        $manager -> flush();
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
