<?php

declare(strict_types=1);

namespace App\Models\Enum;

enum UserRoles: string
{
    case User = 'user';
    case Admin = 'Admin';
}
