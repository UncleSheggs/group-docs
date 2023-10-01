<?php

declare(strict_types=1);

namespace App\Enums;

enum GroupRole: string
{
    case ADMIN = 'admin';
    case MEMBER = 'member';
}
