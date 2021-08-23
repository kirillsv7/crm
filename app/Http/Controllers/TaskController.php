<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddResponseToTaskRequest;
use App\Http\Requests\CreateUpdateTaskRequest;
use App\Models\Project;
use App\Models\Response;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();

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

        $projects = Project::all();

        return view('task.create', compact('title', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUpdateTaskRequest  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CreateUpdateTaskRequest $request)
    {
        $this->authorize('create', Task::class);

        Task::create($request->validated());

        return redirect(route('task.index'))->with('created', true);
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

        $projects = Project::all();

        return view('task.edit', compact('title', 'task', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CreateUpdateTaskRequest  $request
     * @param  Task  $task
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(CreateUpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $task->update($request->validated());

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
        $this->authorize('delete', $id);

        Task::destroy([$id]);

        return redirect(route('task.index'))->with('deleted', true);
    }

    /**
     * Display a listing of the deleted resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleted()
    {
        $tasks = Task::onlyTrashed()->get();

        $title = 'Deleted tasks list';

        return view('task.deleted', compact('title', 'tasks'));
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

        Task::withTrashed()->where('id', $id)->restore();

        return redirect(route('task.deleted'))->with('restored', true);
    }

    public function addResponse(AddResponseToTaskRequest $request, Task $task)
    {
        $this->authorize('addResponse', $task);

        $data            = $request->validated();
        $data['task_id'] = decrypt($data['task_id']);
        $data['user_id'] = auth()->id();

        Response::create($data);

        return redirect(route('task.show', $task->id))->with('responseCreated', true);
    }
}
