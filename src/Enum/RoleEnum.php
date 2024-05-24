<?php

declare(strict_types=1);

namespace App\Enum;

enum RoleEnum: string
{
    case ROLE_USER = 'ROLE_USER';
    case ROLE_FO = 'ROLE_FO';
    case ROLE_BO = 'ROLE_BO';
    case ROLE_ACCOUNTANT = 'ROLE_ACCOUNTANT';
    case ROLE_EDITOR = 'ROLE_EDITOR';
    case ROLE_ADMIN = 'ROLE_ADMIN';
}
