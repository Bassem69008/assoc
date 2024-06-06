<?php

namespace App\DataFixtures;

use App\Factory\FamilyFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FamilyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        FamilyFactory::createMany(80);
    }
}
