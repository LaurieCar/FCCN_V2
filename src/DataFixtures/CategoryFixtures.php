<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $faker->seed(100);

        for($i=0; $i<10; $i++) {
            $category = new Category();
            $category->setName($faker->unique()->jobTitle());
            $manager->persist($category);
        }

        $manager->flush();
    }
}
