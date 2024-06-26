<?php

namespace App\DataFixtures;

use App\Factory\TeacherFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TeacherFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        TeacherFactory::createMany(3);
    }
}
