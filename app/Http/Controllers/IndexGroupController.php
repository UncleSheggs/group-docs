<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\GroupCollection;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class IndexGroupController
{
    /**
     * Group list with members.
     */
    public function __invoke(Request $request): JsonResource
    {
        $groups = Group::query()
            ->withCount('users')
            ->with('users:id,name');

        return GroupResource::collection($groups->cursorPaginate(10));
        // return new GroupCollection($groups->cursorPaginate(10));
    }
}
