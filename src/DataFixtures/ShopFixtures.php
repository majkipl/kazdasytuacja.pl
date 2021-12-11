<?php

namespace App\DataFixtures;

use App\Entity\Shop;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ShopFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $shops = [
            'MEDIA MARKT',
            'SATURN',
            'RTV-EURO-AGD',
            'AGITO',
            'AGD WARSZAWA',
            'BANKUJESZ-ZYSKUJESZ',
            'MEDIADOMEK.PL',
            'MEDIAEXPERT',
            'MERLIN.PL',
            'MORELE.NET',
            'NEONET',
            'PAYBACK',
            'SELGROS',
            'INNE',
            'EMPIK',
        ];

        foreach ($shops as $item) {
            $shop = new Shop();
            $shop->setName($item);
            $manager->persist($shop);
            $manager->flush();
        }
    }
}
