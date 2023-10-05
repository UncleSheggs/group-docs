<?php

declare(strict_types=1);

namespace Sharing\Groups;

use App\Models\User;
use App\Models\Group;
use App\Models\Service;
use Sharing\Groups\Contracts\AdminContract;
use App\Exceptions\InvalidGroupActionException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

final class GroupAdmin implements AdminContract
{
    public function createGroup(User $admin, Service $service, string $name, string $interval, int $limit): Group
    {
        //1. check wallet balance is equal to service cost
        $group = \App\Models\Group::create([
            'service_id' => $service->id,
            'name' => $name,
            'interval' => $interval,
            'limit' => $limit,
        ]);
        $group->users()->attach($admin, [
            'role' => \App\Enums\MembershipRole::ADMIN->value,
            'status' => \App\Enums\MembershipStatus::ACTIVE->value,
        ]);

        return $group;
    }

    public function pendingRequests(User $admin, Group $group): Group
    {
        // 1. check if user is the admin of the group
        $this->isGroupAdmin($admin, $group);

        // 2. return group with related pending members
        return $group
            ->load(['pending_members'])
            ->loadCount(['users', 'pending_members']);

    }

    public function deleteGroup(User $admin, Group $group): void
    {
        // 1. check if user is the admin of the group
        $this->isGroupAdmin($admin, $group);

        // 2. check if are no members in the group
        if (null !== $group->members->first()) {
            throw new InvalidGroupActionException('Cannot delete a group with members');
        }

        //* 3. check if current subscription has expired

        $group->users()->sync([]);
        $group->delete();
    }

    public function acceptRequest(User $admin, Group $group, User $member): Group
    {
        // 1. check if user is the admin of the group
        $this->isGroupAdmin($admin, $group);

        // 2. check if user is already a member of the group
        if ($this->isAlreadyAMember($group, $member)) {
            throw new InvalidGroupActionException('This user is already a member');
        }

        // 3. check if group is full
        $this->isFull($group);

        // 3. check if member is a requesting membership to the group
        if ( ! $this->isRequestingMembership($group, $member)) {
            throw new InvalidGroupActionException('Cannot accept a non-requesting member');
        }

        // 4. if 1 & 2 passes, add member to the group
        $member->groups()
            ->updateExistingPivot(
                $group->id,
                ['status' => \App\Enums\MembershipStatus::ACTIVE->value]
            );

        return $group->refresh();
    }

    public function declineMember(User $admin, Group $group, User $member): void
    {
        // 1. check if user is the admin of the group
        $this->isGroupAdmin($admin, $group);

        // 2. check if member is a requesting member of the group
        if ( ! $this->isRequestingMembership($group, $member)) {
            throw new InvalidGroupActionException('Cannot decline a non-requesting member');
        }

        // 3. if 1 & 2 passes, decline requesting member from joining the group
        $group->pending_members()->detach($member);
    }

    private function isGroupAdmin(User $admin, Group $group): void
    {
        if (!$group->admin->first()->is($admin)) {
            throw new UnauthorizedHttpException('You are not authorized');
        }
    }

    private function isAlreadyAMember(Group $group, User $member): bool
    {
        return null !== $group->users()->where('user_id', $member->id)->first();
    }

    private function isRequestingMembership(Group $group, User $member): bool
    {
        return null !== $group->pending_members()
            ->where('user_id', $member->id)
            ->first();

    }

    private function isFull(Group $group): void
    {
        $intendedGroup = $group->loadCount('users');
        if ($intendedGroup->users_count === $intendedGroup->limit) {
            throw new InvalidGroupActionException('Group is full');
        }
    }
}
