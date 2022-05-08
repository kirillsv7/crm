<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return true;
    }

    public function show(User $user, Task $task)
    {
        return $user->isAdmin ||
            $user->id === $task->project->user->id ||
            $user->hasPermissionTo('task-show');
    }

    public function create(User $user)
    {
        return $user->isAdmin || $user->hasPermissionTo('task-create');
    }

    public function edit(User $user, Task $task)
    {
        return $user->isAdmin || $user->hasPermissionTo('task-update');
    }

    public function update(User $user, Task $task)
    {
        return $user->isAdmin || $user->hasPermissionTo('task-update');
    }

    public function delete(User $user, Task $task)
    {
        return $user->isAdmin || $user->hasPermissionTo('task-delete');
    }

    public function restore(User $user, Task $task)
    {
        return $user->isAdmin || $user->hasPermissionTo('task-restore');
    }

    public function forceDelete(User $user, Task $task)
    {
        return $user->isAdmin || $user->hasPermissionTo('task-force-delete');
    }

    public function deleted(User $user)
    {
        return $user->isAdmin || $user->hasPermissionTo('task-deleted');
    }

    public function manageMedia(User $user, Task $task)
    {
        return $user->isAdmin || $user->hasPermissionTo('task-manage-media');
    }

    public function addResponse(User $user, Task $task)
    {
        return $user->isAdmin ||
            $user->id === $task->project->user->id ||
            $user->hasPermissionTo('task-add-response');
    }
}
