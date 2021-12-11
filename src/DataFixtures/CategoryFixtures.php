<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            'GOLARKI',
            'TRYMERY i ZESTAWY DO PIELĘGNACJI CIAŁA',
            'STRZYŻARKI DO WŁOSÓW'
        ];

        foreach ($categories as $item) {
            $category = new Category();
            $category->setName($item);
            $manager->persist($category);
            $manager->flush();
        }
    }
}
