<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddResponseToTaskRequest;
use App\Http\Requests\CreateUpdateTaskRequest;
use App\Models\Project;
use App\Models\Response;
use App\Models\Task;
use App\Services\SpatieMediaLibrary\AddMediaToModel;

class TaskController extends Controller
{

    const PAGINATE = 20;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::filterByStatus()
                     ->filterAssignedToUser()
                     ->orderByDesc('id')
                     ->paginate(self::PAGINATE)
                     ->withQueryString();

        $title = 'Task list';

        return view('task.index', compact('title', 'tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Task::class);

        $title = 'Task create';

        $projects = Project::all('id', 'title');

        return view('task.create', compact('title', 'projects'));
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

        return redirect(route('task.edit', $task->id))->with('created', true);
    }

    /**
     * Display the specified resource.
     *
     * @param  Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $title = 'Task: '.$task->title;

        return view('task.show', compact('title', 'task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Task  $task
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $title = 'Task edit: '.$task->title;

        $projects = Project::all('id', 'title');

        return view('task.edit', compact('title', 'task', 'projects'));
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

        return redirect(route('task.edit', $task->id))->with('updated', true);
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
        $task = Task::findOrFail($id);

        $this->authorize('delete', $task);

        $task->delete();

        return redirect(route('task.index'))->with('deleted', true);
    }

    /**
     * Display a listing of the deleted resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleted()
    {
        $tasks = Task::onlyTrashed()
                     ->filterByStatus()
                     ->filterAssignedToUser()
                     ->orderByDesc('id')
                     ->paginate(self::PAGINATE)
                     ->withQueryString();

        $title = 'Deleted tasks list';

        return view('task.index', compact('title', 'tasks'));
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
        $task = Task::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $task);

        $task->restore();

        return redirect(route('task.deleted'))->with('restored', true);
    }

    /**
     * @param  Task  $task
     * @param $mediaId
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\MediaCannotBeDeleted
     */
    public function removeMedia(Task $task, $mediaId)
    {
        $this->authorize('manageMedia', $task);

        $task->deleteMedia($mediaId);
    }

    /**
     * @param  AddResponseToTaskRequest  $request
     * @param  Task  $task
     * @param  AddMediaToModel  $addMediaToModel
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function addResponse(AddResponseToTaskRequest $request, Task $task, AddMediaToModel $addMediaToModel)
    {
        $this->authorize('addResponse', $task);

        $data            = $request->except('media');
        $data['task_id'] = decrypt($data['task_id']);
        $data['user_id'] = auth()->id();

        $response = Response::create($data);

        $addMediaToModel($request->input('media', []), $response);

        return redirect(route('task.show', $task->id))->with('responseCreated', true);
    }
}
