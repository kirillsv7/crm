<?php

namespace App\Services;

use App\Models\Response;
use App\Models\Task;
use App\Services\SpatieMediaLibrary\AddMediaToModel;
use Illuminate\Support\Arr;

class TaskService
{
    public function store(array $formData): Task
    {
        $task = Task::create(Arr::except($formData, ['files']));

        if (Arr::exists($formData, 'files')) {
            $addMediaToModel = new AddMediaToModel();
            $addMediaToModel($formData['files'], $task);
        }

        return $task;
    }

    public function update(Task $task, array $formData): Task
    {
        $task->update(Arr::except($formData, ['files']));

        if (Arr::exists($formData, 'files')) {
            $addMediaToModel = new AddMediaToModel();
            $addMediaToModel($formData['files'], $task);
        }

        return $task;
    }

    public function addResponse(array $formData): Response
    {
        $data            = Arr::except($formData, ['files']);
        $data['task_id'] = decrypt($data['task_id']);
        $data['user_id'] = auth()->id();

        $task = Response::create($data);

        if (Arr::exists($formData, 'files')) {
            $addMediaToModel = new AddMediaToModel();
            $addMediaToModel($formData['files'], $task);
        }

        return $task;
    }
}
