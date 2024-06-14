<?php

namespace App\DataFixtures;

use App\Factory\ClassroomFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ClassroomFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        ClassroomFactory::createMany(3);
    }

    public function getDependencies(): array
    {
        return [
            TeacherFixtures::class,
        ];
    }
}
