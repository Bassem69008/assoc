<?php

namespace App\DataFixtures;

use App\Factory\SubjectFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SubjectFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        SubjectFactory::createMany(10);
    }

    public function getDependencies()
    {
        return [
            TeacherFixtures::class,
        ];
    }
}
