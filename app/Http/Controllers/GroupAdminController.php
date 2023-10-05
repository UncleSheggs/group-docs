<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\Service;
use Illuminate\Http\Request;
use Sharing\Groups\GroupAdmin;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\GroupResource;
use App\Http\Requests\StoreGroupRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\InvalidGroupActionException;

class GroupAdminController extends Controller
{
    public function store(StoreGroupRequest $request, GroupAdmin $admin): JsonResponse
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

    public function pending(Group $group, User $admin, GroupAdmin $groupAdmin): JsonResponse
    {
        try {
            $group = $groupAdmin->pendingRequests($admin, $group);

        } catch (InvalidGroupActionException $exception) {
            /**
             * @status 401
             */
            return new JsonResponse(
                [$exception->getMessage()],
                Response::HTTP_UNAUTHORIZED
             );

        }
        /**
         * @status 200
         * @body GroupResource
         */
        return new JsonResponse(
            new GroupResource($group),
            Response::HTTP_OK
        );
    }

    public function accept(Group $group, User $admin, User $member, GroupAdmin $groupAdmin): JsonResponse
    {
        try {
            $group = $groupAdmin->acceptRequest(
                admin: $admin,
                group: $group,
                member: $member
            );

            return new JsonResponse(
                new GroupResource($group->loadCount('users')->load('users')),
                Response::HTTP_CREATED
            );

        } catch (InvalidGroupActionException $exception) {
            /**
             * @status 400
             */
            return new JsonResponse(
                [$exception->getMessage()],
                Response::HTTP_BAD_REQUEST
             );

        }

    }

    public function decline(Group $group, User $admin, User $member, GroupAdmin $groupAdmin)
    {
        try {

            $groupAdmin->declineMember(
                admin: $admin,
                group: $group,
                member: $member
            );
            /**
             * @status 204
             */
            return new JsonResponse(
                [],
                Response::HTTP_NO_CONTENT
            );

        } catch (InvalidGroupActionException $exception) {
            /**
             * @status 400
             */
            return new JsonResponse(
                [$exception->getMessage()],
                Response::HTTP_BAD_REQUEST
             );
        }
    }

    public function delete(Group $group, User $admin, GroupAdmin $groupAdmin)
    {
        try {

            $groupAdmin->deleteGroup(
                admin: $admin,
                group: $group
            );
            /**
             * @status 204
             */
            return new JsonResponse(
                [],
                Response::HTTP_NO_CONTENT
            );

        } catch (InvalidGroupActionException $exception) {
            /**
             * @status 400
             */
            return new JsonResponse(
                [$exception->getMessage()],
                Response::HTTP_BAD_REQUEST
             );
        }
    }
}
