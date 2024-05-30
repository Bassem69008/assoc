<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\Users\User;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AccountIsActiveUserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        /*
         * Avoid user not active to login.
         */
        /*  if (!$user->getIsVerified()) {
              throw new CustomUserMessageAccountStatusException('Compte non activé');
          } */
    }

    public function checkPostAuth(UserInterface $user): void
    {
    }
}
