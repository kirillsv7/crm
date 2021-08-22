<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();

        $title = 'Project list';

        return view('project.index', compact('title', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Project::class);

        $title = 'Project create';

        return view('project.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', Project::class);

        Project::create($request->validated());

        return redirect(route('project.index'))->with('created', true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $title = 'Project: '.$project->title;

        return view('project.show', compact('title', 'project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Project  $project
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        $title = 'Project edit: '.$project->title;

        $clients = Client::all();

        $users = User::all();

        return view('project.edit', compact('title', 'project', 'clients', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Project  $project
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $project->update($request->validated());

        return redirect(route('project.edit', $project->id))->with('updated', true);
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

        Project::destroy([$id]);

        return redirect(route('project.index'))->with('deleted', true);
    }

    /**
     * Display a listing of the deleted resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleted()
    {
        $projects = Project::onlyTrashed()->get();

        $title = 'Deleted projects list';

        return view('project.deleted', compact('title', 'projects'));
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

        Project::withTrashed()->where('id', $id)->restore();

        return redirect(route('project.deleted'))->with('restored', true);
    }
}
