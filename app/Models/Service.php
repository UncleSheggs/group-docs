<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Service extends Model
{
    use HasFactory;


    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }
}
