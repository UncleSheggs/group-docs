<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\Service;
use Sharing\Groups\Admin;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\GroupResource;
use App\Http\Requests\StoreGroupRequest;
use Symfony\Component\HttpFoundation\Response;

final class StoreGroupController extends Controller
{
    /**
     * Add members to a Group.
     */
    public function __invoke(StoreGroupRequest $request, Admin $admin): JsonResponse
    {
        $group = $admin->createGroup(
            admin: User::find($request->validated()['admin_id']), // authenticated user
            service: Service::find($request->validated()['service_id']),
            name: $request->validated()['name'],
            interval: $request->validated()['interval'],
            limit: $request->validated()['limit']
        );

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
