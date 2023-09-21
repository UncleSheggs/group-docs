<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class StoreGroupController extends Controller
{
    /**
     * Add members to a Group.
     */
    public function __invoke(StoreGroupRequest $request): JsonResponse
    {
        $group = Group::query()
            ->create([
                'name' => $request->validated()['name']
            ]);
        $group->users()->sync($request->validated()['member_ids']);
        /**
         * @status 201
         * @body GroupResource
         */
        return new JsonResponse(
            new GroupResource($group->loadCount('users')->load('users')),
            Response::HTTP_CREATED
        );

    }
}
