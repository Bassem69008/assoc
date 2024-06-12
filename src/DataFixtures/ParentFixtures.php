<?php

namespace App\DataFixtures;

use App\Factory\FamilyFactory;
use App\Factory\ParentEntityFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ParentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Get all families
        $families = FamilyFactory::all();

        // For each family, create two parents
        foreach ($families as $family) {
            ParentEntityFactory::new()->create(['family' => $family, 'gender' => 'M']);
            ParentEntityFactory::new()->create(['family' => $family, 'gender' => 'F']);
        }
    }
}
