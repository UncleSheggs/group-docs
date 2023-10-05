<?php

declare(strict_types=1);

namespace Sharing\Groups;

use App\Exceptions\InvalidGroupActionException;
use App\Models\Group;
use App\Models\User;
use Sharing\Groups\Contracts\MemberContract;

final class GroupMember implements MemberContract
{
    public function requestToJoin(Group $group, User $member): void
    {
        // 1. make sure group is not at its capacity
        $this->isFull($group);

        // 2. make sure intending member is not a member already
        if ($this->isAlreadyAMember($group, $member)) {
            throw new InvalidGroupActionException('You are already a member of this group');
        }

        // 3. make sure intending member is not requested to join already
        if ($this->alreadyRequestedMembership($group, $member)) {
            throw new InvalidGroupActionException('You already requested to join this group');
        }

        // 4. intending member has enough balance to join

        // 5. request to join Group
        $group->users()->attach($member, ['role' => 'member']);
    }

    public function withdrawJoinRequest(Group $group, User $member): void
    {
        // 1. Already a member?
        if ($this->isAlreadyAMember($group, $member)) {
            throw new InvalidGroupActionException('You are already a member, please request to leave instead');
        }

        // 2. Not an Intending member?
        if ( ! $this->alreadyRequestedMembership($group, $member)) {
            throw new InvalidGroupActionException('You do not have a pending request to join this group');
        }

        // 2. Withdraw membership request
        $group->pending_members()->detach($member);
    }

    public function leaveGroup(Group $group, User $member): void
    {
        // 1. Is user actually a member of the group?
        if ( ! $this->isAlreadyAMember($group, $member)) {
            throw new InvalidGroupActionException('You are not a member of this group');
        }

        // 2. remove from Group
        $group->users()->detach($member);
    }

    private function isFull(Group $group): void
    {
        $intendedGroup = $group->loadCount('users');
        if ($intendedGroup->users_count === $intendedGroup->limit) {
            throw new InvalidGroupActionException('Intending Group is full');
        }
    }

    private function isAlreadyAMember(Group $group, User $member): bool
    {
        return null !== $group->users()->where('user_id', $member->id)->first();
    }

    private function alreadyRequestedMembership(Group $group, User $member): bool
    {
        return null !== $group->pending_members()->where('user_id', $member->id)->first();
    }
}
