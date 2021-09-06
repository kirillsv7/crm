<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUpdateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(User::paginate(User::PAGINATE));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUpdateUserRequest  $request
     * @param  UserService  $service
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CreateUpdateUserRequest $request, UserService $service)
    {
        //$this->authorize('create', User::class);

        $user = $service->store($request->validated());

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CreateUpdateUserRequest  $request
     * @param  User  $user
     * @param  UserService  $service
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(CreateUpdateUserRequest $request, User $user, UserService $service)
    {
        //$this->authorize('update', $user);

        $user = $service->update($user, $request->validated());

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return response()->json(['message' => 'User deleted']);
    }
}
