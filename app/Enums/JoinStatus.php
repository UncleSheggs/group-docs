<?php

declare(strict_types=1);

namespace App\Enums;

enum JoinStatus: string
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
}
