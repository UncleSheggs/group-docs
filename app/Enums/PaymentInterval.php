<?php

declare(strict_types=1);

namespace App\Enums;

enum PaymentInterval: string
{
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case QUATERLY = 'quarterly';
    case YEARLY = 'yearly';
}
