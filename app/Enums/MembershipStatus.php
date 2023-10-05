<?php

declare(strict_types=1);

namespace App\Enums;

enum MembershipStatus: string
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
}
