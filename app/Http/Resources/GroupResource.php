<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'group_name' => $this->name,
            'type' => $this->service->type,
            /** @var integer $members_count. */
            'members_count' => $this->users_count,
            'members' => UserResource::collection($this->whenLoaded('users')),
            'pending_members' => UserResource::collection($this->whenLoaded('pending_members'))
        ];
    }
}
