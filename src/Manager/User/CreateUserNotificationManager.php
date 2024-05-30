<?php

declare(strict_types=1);

namespace App\Manager\User;

use App\Entity\Users\User;
use App\Service\Emails\SendMailService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;

class CreateUserNotificationManager extends UserNotificationManager
{
    public const TEMPLATE = 'add_user';

    public const SUBJECT = 'Bienvenue';

    public function __construct(
        private readonly LoginLinkHandlerInterface $loginLinkHandler,
        LoggerInterface $logger,
        SendMailService $sendMailService,
    ) {
        parent::__construct($logger, $sendMailService);
    }

    public function notifyAddedUser(User $user): void
    {
        $loginLinkDetails = $this->loginLinkHandler->createLoginLink($user);
        $this->notifyUser(
            $user,
            self::SUBJECT,
            self::TEMPLATE,
            ['user_first_name' => $user->getFirstName(), 'reset_password_url' => $loginLinkDetails->getUrl()]
        );
    }
}
