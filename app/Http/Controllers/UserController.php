<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    const PAGINATE = 20;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(self::PAGINATE);

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

        $data = $request->except('password');

        $data['password'] = Hash::make($request->input('password'));

        $user = User::create($data);

        event(new Registered($user));

        return redirect(route('user.index'))->with('created', true);
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

        $user->update($data);

        // Only Admin can set another user as Admin
        if (auth()->user()->can('assignAdminRole', $user)) {
            $request->input('is_admin')
                ? $user->assignRole('admin')
                : $user->removeRole('admin');
        }

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
        $user = User::findOrFail($id);

        $this->authorize('delete', $user);

        $user->delete();

        return redirect(route('user.index'))->with('deleted', true);
    }

    /**
     * Display a listing of the deleted resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleted()
    {
        $users = User::onlyTrashed()->paginate(self::PAGINATE);

        $title = 'Deleted users list';

        return view('user.index', compact('title', 'users'));
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
        $user = User::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $user);

        $user->restore();

        return redirect(route('user.deleted'))->with('restored', true);
    }
}
