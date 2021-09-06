<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUpdateTaskRequest;
use App\Http\Resources\V1\TaskResource;
use App\Models\Task;
use App\Services\SpatieMediaLibrary\AddMediaToModel;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TaskResource::collection(
            Task::filterByStatus()
                ->filterAssignedToUser()
                ->orderByDesc('id')
                ->paginate(Task::PAGINATE)
                ->withQueryString()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUpdateTaskRequest  $request
     * @param  AddMediaToModel  $addMediaToModel
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CreateUpdateTaskRequest $request, AddMediaToModel $addMediaToModel)
    {
        $this->authorize('create', Task::class);

        $task = Task::create($request->except('media'));

        $addMediaToModel($request->input('media', []), $task);

        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     *
     * @param  Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CreateUpdateTaskRequest  $request
     * @param  Task  $task
     * @param  AddMediaToModel  $addMediaToModel
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(CreateUpdateTaskRequest $request, Task $task, AddMediaToModel $addMediaToModel)
    {
        $this->authorize('update', $task);

        $task->update($request->except('media'));

        $addMediaToModel($request->input('media', []), $task);

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Task  $task
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return response()->json(['message' => 'Task deleted']);
    }
}
