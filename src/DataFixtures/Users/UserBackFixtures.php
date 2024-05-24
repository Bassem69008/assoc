<?php

namespace App\DataFixtures\Users;

use App\Entity\Users\User;
use App\Factory\Users\UserBackFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserBackFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /***  Fix Admin User ***/
        UserBackFactory::createOne([
            'email' => 'admin@example.com',
            'roles' => ['ROLE_ADMIN'],
            'isVerified' => true,
        ]);

        /* Back Editor */
        UserBackFactory::createOne([
            'email' => 'editor@example.com',
            'roles' => ['ROLE_EDITOR'],
            'isVerified' => true,
        ]);

        /* Back ACCOUNTANT */
        UserBackFactory::createOne([
            'email' => 'accountant@example.com',
            'roles' => ['ROLE_ACCOUNTANT'],
            'isVerified' => true,
        ]);
    }
}
