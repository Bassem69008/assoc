<?php

namespace App\DataFixtures\Users;

use App\Entity\Users\User;
use App\Factory\Users\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /***  Fix Admin User ***/
        UserFactory::createOne([
            'email' => 'admin@example.com',
            'roles' => ['ROLE_ADMIN'],
            'isVerified' => true,
        ]);

        /* Back Editor */
        UserFactory::createOne([
            'email' => 'editor@example.com',
            'roles' => ['ROLE_EDITOR'],
            'isVerified' => true,
        ]);

        /* Back ACCOUNTANT */
        UserFactory::createOne([
            'email' => 'accountant@example.com',
            'roles' => ['ROLE_ACCOUNTANT'],
            'isVerified' => true,
        ]);
    }
}
