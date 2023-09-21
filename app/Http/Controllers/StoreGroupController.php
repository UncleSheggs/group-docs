<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\GroupResource;
use App\Http\Requests\StoreGroupRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreGroupController extends Controller
{
    /**
     * Handle the incoming request.
     *
     */
    public function __invoke(StoreGroupRequest $request): JsonResponse
    {
        $group = Group::query()->create(['name' => $request->validated()['name']]);

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
