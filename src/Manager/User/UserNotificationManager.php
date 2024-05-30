<?php

declare(strict_types=1);

namespace App\Manager\User;

use App\Entity\Users\User;
use App\Manager\NotificationManager;
use App\Service\Emails\SendMailService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Security\Http\LoginLink\Exception\ExpiredLoginLinkException;

class UserNotificationManager implements NotificationManager
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly ?SendMailService $sendMailService,
    ) {
    }

    /**
     * @param array<string, string|null> $context
     */
    public function notifyUser(User $user, string $subject, string $template, ?array $context = []): void
    {
        try {
            $this->sendMailService->send(
                'contact@example.com',
                $user->getEmail(),
                $subject,
                $context,
                $template,
            );
        } catch (TransportExceptionInterface|ExpiredLoginLinkException $exception) {
            // If the link is expired or has a transport exception, log the error.
            $this->logEmailError($user->getEmail(), $exception->getMessage());
        } catch (\Exception $exception) {
            // Catch any other exceptions that might arise and log them.
            $this->logUnexpectedError($user->getEmail(), $exception->getMessage());
        }
    }

    private function logEmailError(string $email, string $message): void
    {
        $this->logger->error(
            sprintf('Failed to send email to %s : %s', $email, $message)
        );
    }

    private function logUnexpectedError(string $email, string $message): void
    {
        $this->logger->error(
            sprintf('An unexpected error occurred while sending email to %s: %s', $email, $message)
        );
    }
}
