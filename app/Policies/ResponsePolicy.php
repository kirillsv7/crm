<?php

namespace App\Policies;

use App\Models\Response;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResponsePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Response $response)
    {
        return $user->hasPermissionTo('response-delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Response $response)
    {
        return $user->hasPermissionTo('response-restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Response $response)
    {
        return $user->hasPermissionTo('response-forceDelete');
    }
}
