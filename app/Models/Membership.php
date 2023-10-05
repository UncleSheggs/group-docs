<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\AdminScope;
use App\Models\Scopes\MemberScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

final class Membership extends Pivot
{
    use HasFactory;
    protected $table = 'memberships';

    protected $casts = [
        'role' => \App\Enums\MembershipRole::class,
        'status' => \App\Enums\MembershipStatus::class,
    ];

    // protected static function booted(): void
    // {
    //     static::addGlobalScope(new AdminScope);
    //     static::addGlobalScope(new MemberScope);
    // }
}
