<?php

declare(strict_types=1);

namespace App\Models\Enum;
enum Statuses: string
{
    case Active = "active";
    case Wait = "wait";
}
