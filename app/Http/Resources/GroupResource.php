<?php

namespace App\Http\Resources;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            /** @var integer $members_count. */
            'members_count' => $this->users_count,
            'members' => UserResource::collection($this->whenLoaded('users'))

        ];
    }
}
