<?php

declare(strict_types=1);

namespace Sharing\Groups\Contracts;

use App\Models\Group;
use App\Models\User;

interface MemberContract
{
    public function requestToJoin(Group $group, User $member);

    public function withdrawJoinRequest(Group $group, User $member);

    public function leaveGroup(Group $group, User $member);
}
