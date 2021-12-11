<?php

namespace App\DataFixtures;

use App\Factory\FlashlightFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FlashlightFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        FlashlightFactory::createMany(100);

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
