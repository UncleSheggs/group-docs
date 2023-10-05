<?php

declare(strict_types=1);

namespace App\Enums;

use ArchTech\Enums\Values;

enum PaymentInterval: string
{
    use Values;

    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case QUATERLY = 'quarterly';
    case YEARLY = 'yearly';
}
