<?php

declare(strict_types=1);

namespace App\Models\Enum;
enum UserStatuses: string
{
    case Active = "active";
    case Wait = "wait";
}
