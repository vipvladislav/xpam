<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Factory\ArticleFactory;
use App\Factory\CategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        ArticleFactory::new()->createMany(21);
        CategoryFactory::new()->createMany(10);
                $manager->flush();
    }
}
