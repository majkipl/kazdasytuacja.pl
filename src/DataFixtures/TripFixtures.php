<?php

namespace App\DataFixtures;

use App\Factory\TripFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TripFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        TripFactory::createMany(100);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            GenderFixtures::class,
            ShopFixtures::class,
            CategoryFixtures::class
        ];
    }

}
