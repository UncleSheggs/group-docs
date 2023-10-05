<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Group extends Model
{
    use HasFactory;

    protected $casts = [
        'interval' => \App\Enums\PaymentInterval::class,
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'memberships')
            ->as('membership')
            ->using(Membership::class)
            ->wherePivot('status', \App\Enums\MembershipStatus::ACTIVE->value)
            ->withPivot([
                'role',
                'status',
            ])
            ->withTimestamps();
    }

    // public function active_members(): BelongsToMany
    // {
    //     return $this->users()
    //         ->wherePivot('status', \App\Enums\MembershipStatus::ACTIVE->value);
    // }

    public function pending_members(): BelongsToMany
    {
            return $this->belongsToMany(User::class, 'memberships')
                ->as('membership')
                ->using(Membership::class)
                ->wherePivot('status', \App\Enums\MembershipStatus::PENDING->value)
                ->withPivot([
                    'role',
                    'status',
                ])
            ->withTimestamps();
    }

    public function admin()
    {
        return $this->users()
            ->wherePivot('role', \App\Enums\MembershipRole::ADMIN->value);
    }

    public function members(): BelongsToMany
    {
        return $this->users()
            ->wherePivot('role', \App\Enums\MembershipRole::MEMBER->value)
            ->wherePivot('status', \App\Enums\MembershipStatus::ACTIVE->value);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
