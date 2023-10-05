<?php

declare(strict_types=1);

namespace Sharing\Groups\Contracts;

use App\Models\Group;
use App\Models\Service;
use App\Models\User;

interface AdminContract
{
    public function createGroup(User $admin, Service $service, string $name, string $interval, int $limit): Group;

    public function pendingRequests(User $admin, Group $group);

    public function deleteGroup(User $admin, Group $group);

    public function acceptRequest(User $admin, Group $group, User $member): Group;

    public function declineMember(User $admin, Group $group, User $member);
}
