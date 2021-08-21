<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateUserRequest;
use App\Models\User;
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
        $users = User::all();

        $title = 'User list';

        return view('user.index', compact('title', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', User::class);

        $title = 'User create';

        return view('user.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUpdateUserRequest  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CreateUpdateUserRequest $request)
    {
        $this->authorize('create', User::class);

        User::create($request->validated());

        return redirect(route('user.index'))->with('created', true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $title = 'User edit: '.$user->name;

        return view('user.edit', compact('title', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CreateUpdateUserRequest  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(CreateUpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $data = $request->except('password', 'is_admin');
        // Update password only if itn't null
        if ($request->input('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }
        // Only Admin can set another user as Admin
        if (auth()->user()->can('modifyIsAdmin', $user)) {
            $data['is_admin'] = $request->input('is_admin');
        }

        $user->update($data);

        return redirect(route('user.edit', $user->id))->with('updated', true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        $this->authorize('delete', $id);

        User::destroy([$id]);

        return redirect(route('user.index'))->with('deleted', true);
    }

    /**
     * Display a listing of the deleted resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleted()
    {
        $users = User::onlyTrashed()->get();

        $title = 'Deleted users list';

        return view('user.deleted', compact('title', 'users'));
    }

    /**
     * Restore the specified resource to storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restore($id)
    {
        $this->authorize('restore', $id);

        User::withTrashed()->where('id', $id)->restore();

        return redirect(route('user.deleted'))->with('restored', true);
    }
}
