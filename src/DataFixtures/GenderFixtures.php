<?php

namespace App\DataFixtures;

use App\Entity\Gender;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenderFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $genders = [
            'kobieta',
            'mężczyzna'
        ];

        foreach ($genders as $item) {
            $gender = new Gender();
            $gender->setName($item);
            $manager->persist($gender);
            $manager->flush();
        }
    }
}
