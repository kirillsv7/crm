<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUpdateUserRequest;
use App\Http\Resources\V1\User\ListResource as UserListResource;
use App\Http\Resources\V1\User\Resource as UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(
            User::query()
                ->with(['roles'])
                ->paginate()
        );
    }

    public function store(CreateUpdateUserRequest $request, UserService $service): UserResource
    {
        $this->authorize('create', User::class);

        $user = $service->store($request->validated());

        return new UserResource($user);
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    public function update(CreateUpdateUserRequest $request, User $user, UserService $service): UserResource
    {
        $this->authorize('update', $user);

        $user = $service->update($user, $request->validated());

        $user->load('roles');

        return new UserResource($user);
    }

    public function destroy(User $user): JsonResponse
    {
        $this->authorize('delete', $user);

        $user->delete();

        return response()->json(['message' => 'User deleted']);
    }

    public function deleted(): AnonymousResourceCollection
    {
        return UserResource::collection(
            User::query()
                ->onlyTrashed()
                ->paginate()
        );
    }

    public function restore($id): JsonResponse
    {
        $user = User::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $user);

        $user->restore();

        return response()->json(['message' => 'User restored']);
    }

    public function list(): AnonymousResourceCollection
    {
        return UserListResource::collection(
            User::query()
                ->select(['id', 'name'])
                ->with(['roles'])
                ->withTrashed()
                ->get()
        );
    }
}