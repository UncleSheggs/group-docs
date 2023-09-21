<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\GroupResource;
use App\Http\Resources\GroupCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexGroupController
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
