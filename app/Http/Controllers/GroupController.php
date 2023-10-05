<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Resources\GroupResource;
use Illuminate\Http\Resources\Json\JsonResource;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class GroupController extends Controller
{
    public function index(Request $request): JsonResource
    {
        $groups = \App\Models\Group::query()
            ->withCount(['users'])
            ->with(['users:id,name', 'service:id,type'])
            ->latest();

        if ($request->get('search')) {

            $groupSearch = Search::new()
                ->addFullText($groups, ['name'], ['mode' => 'boolean'])
                ->add($groups, ['service.type'])
                ->dontParseTerm()
                ->simplePaginate(5)
                ->search($request->get('search'));

            return GroupResource::collection($groupSearch->withQueryString());
        }

        return GroupResource::collection($groups->simplePaginate(5));
    }

    public function show(Group $group)
    {
        return new GroupResource($group->loadCount('users')->load(['users:id,name', 'service:id,type']));
    }
}
