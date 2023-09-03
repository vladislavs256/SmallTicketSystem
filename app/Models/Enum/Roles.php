<?php

declare(strict_types=1);
namespace App\Models\Enum;

enum Roles: string
{
    case User = 'user';
    case Admin = 'admin';
}
