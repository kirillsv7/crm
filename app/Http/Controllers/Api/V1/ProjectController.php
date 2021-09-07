<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUpdateProjectRequest;
use App\Http\Resources\V1\ProjectResource;
use App\Models\Project;
use App\Services\SpatieMediaLibrary\AddMediaToModel;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProjectResource::collection(
            Project::withCount('tasks')
                   ->filterByStatus()
                   ->filterAssignedToUser()
                   ->orderByDesc('id')
                   ->paginate(Project::PAGINATE)
                   ->withQueryString()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUpdateProjectRequest  $request
     * @param  AddMediaToModel  $addMediaToModel
     * @return ProjectResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CreateUpdateProjectRequest $request, AddMediaToModel $addMediaToModel)
    {
        $this->authorize('create', Project::class);

        $project = Project::create($request->except('media'));

        $addMediaToModel($request->input('media', []), $project);

        return new ProjectResource($project);
    }

    /**
     * Display the specified resource.
     *
     * @param  Project  $project
     * @return ProjectResource
     */
    public function show(Project $project)
    {
        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CreateUpdateProjectRequest  $request
     * @param  Project  $project
     * @param  AddMediaToModel  $addMediaToModel
     * @return ProjectResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(CreateUpdateProjectRequest $request, Project $project, AddMediaToModel $addMediaToModel)
    {
        $this->authorize('update', $project);

        $project->update($request->except('media'));

        $addMediaToModel($request->input('media', []), $project);

        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Project  $project
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        return response()->json(['message' => 'Project deleted']);
    }

    /**
     * Display a listing of the deleted resources.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function deleted()
    {
        return ProjectResource::collection(Project::onlyTrashed()->paginate(Project::PAGINATE));
    }

    /**
     * Restore the specified resource to storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restore($id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $project);

        $project->restore();

        return response()->json(['message' => 'Project restored']);
    }
}
