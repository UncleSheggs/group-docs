<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use Sharing\Groups\GroupMember;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\GroupResource;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\InvalidGroupActionException;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupMemberController extends Controller
{
    public function store(Request $request, Group $group, User $member, GroupMember $groupMember): JsonResponse
    {
        try {

            $groupMember->requestToJoin($group, $member);
            /**
             * @status 201
             * @body GroupResource
             */
            return new JsonResponse(
                new GroupResource(
                    $group
                    ->loadCount(['pending_members' => static fn($query) => $query->where('user_id', $member->id)])
                    ->load(['pending_members' => static fn($query) => $query->where('user_id', $member->id)])
                ),
                Response::HTTP_CREATED
            );

        } catch(InvalidGroupActionException $exception) {

            return new JsonResponse(
                [$exception->getMessage()],
                Response::HTTP_BAD_REQUEST
            );

        }

    }

    public function withdraw(Request $request, Group $group, User $member, GroupMember $groupMember)
    {
        try {

            $groupMember->withdrawJoinRequest(
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

    public function leave(Request $request, Group $group, User $member, GroupMember $groupMember)
    {
        try {

            $groupMember->leaveGroup(
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
}
