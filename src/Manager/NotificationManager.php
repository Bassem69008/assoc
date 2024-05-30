<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Users\User;

interface NotificationManager
{
    /**
     * @param array<string, string|null> $context
     */
    public function notifyUser(User $user, string $subject, string $template, ?array $context = []): void;
}
