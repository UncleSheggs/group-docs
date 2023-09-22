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
     * list all groups with their members.
     *
     */
    public function __invoke(Request $request): JsonResource
    {
        $groups = Group::query()
            ->withCount('users')
            ->with('users:id,name')
            ->latest();

        return GroupResource::collection($groups->simplePaginate(5));
        // return new GroupCollection($groups->simplePaginate(5));
    }
}
