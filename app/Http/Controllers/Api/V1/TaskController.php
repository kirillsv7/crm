<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddResponseToTaskRequest;
use App\Http\Requests\CreateUpdateTaskRequest;
use App\Http\Resources\V1\ResponseResource;
use App\Http\Resources\V1\TaskResource;
use App\Models\Task;
use App\Services\SpatieMediaLibrary\AddMediaToModel;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return TaskResource::collection(
            Task::query()
                ->filterByProject()
                ->filterByClient()
                ->filterByUser()
                ->filterByStatus()
                ->orderByDesc('id')
                ->paginate()
                ->withQueryString()
        );
    }

    public function store(CreateUpdateTaskRequest $request, AddMediaToModel $addMediaToModel): TaskResource
    {
        $this->authorize('create', Task::class);

        $task = Task::create($request->except('media'));

        $addMediaToModel($request->input('media', []), $task);

        return new TaskResource($task);
    }

    public function show(Task $task): TaskResource
    {
        $task->load(['media', 'responses']);

        return new TaskResource($task);
    }

    public function update(CreateUpdateTaskRequest $request, Task $task, AddMediaToModel $addMediaToModel): TaskResource
    {
        $this->authorize('update', $task);

        $task->update($request->except('media'));

        $addMediaToModel($request->input('media', []), $task);

        return new TaskResource($task);
    }

    public function destroy(Task $task): JsonResponse
    {
        $this->authorize('delete', $task);

        $task->delete();

        return response()->json(['message' => 'Task deleted']);
    }

    public function deleted(): AnonymousResourceCollection
    {
        return TaskResource::collection(
            Task::query()
                ->onlyTrashed()
                ->filterByProject()
                ->filterByClient()
                ->filterByUser()
                ->filterByStatus()
                ->orderByDesc('id')
                ->paginate()
                ->withQueryString()
        );
    }

    public function restore($id): JsonResponse
    {
        $task = Task::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $task);

        $task->restore();

        return response()->json(['message' => 'Task restored']);
    }

    public function statusList(): JsonResponse
    {
        return response()->json(['data' => Task::$statusList]);
    }

    public function addResponse(AddResponseToTaskRequest $request, TaskService $service): ResponseResource
    {
        $task = Task::findOrFail(decrypt($request->input('task_id')));

        $this->authorize('addResponse', $task);

        $response = $service->addResponse($request->validated());

        return new ResponseResource($response);
    }
}
