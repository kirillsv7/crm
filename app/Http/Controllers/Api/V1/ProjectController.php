<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUpdateProjectRequest;
use App\Http\Resources\V1\Project\ListResource as ProjectListResource;
use App\Http\Resources\V1\Project\Resource as ProjectResource;
use App\Models\Project;
use App\Models\Task;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{

    public function index(): AnonymousResourceCollection
    {
        return ProjectResource::collection(
            Project::query()
                   ->with([
                       'user:id,name,deleted_at',
                       'client:id,company',
                   ])
                   ->withCount('tasks')
                   ->filterByStatus()
                   ->filterAssignedToUser()
                   ->orderByDesc('id')
                   ->paginate()
                   ->withQueryString()
        );
    }

    public function store(CreateUpdateProjectRequest $request, ProjectService $service): ProjectResource
    {
        $this->authorize('create', Project::class);

        $project = $service->store($request->validated());

        return new ProjectResource($project);
    }

    public function show(Project $project): ProjectResource
    {
        $project->load('media');

        return new ProjectResource($project);
    }

    public function update(
        CreateUpdateProjectRequest $request,
        Project $project,
        ProjectService $service
    ): ProjectResource {
        $this->authorize('update', $project);

        $project = $service->update($project, $request->validated());

        return new ProjectResource($project);
    }

    public function destroy(Project $project): JsonResponse
    {
        $this->authorize('delete', $project);

        $project->delete();

        return response()->json(['message' => 'Project deleted']);
    }

    public function deleted(): AnonymousResourceCollection
    {
        return ProjectResource::collection(
            Project::query()
                   ->with([
                       'user:id,name,deleted_at',
                       'client:id,company',
                   ])
                   ->withCount('tasks') // TODO: Return 0, needs to be fixed
                   ->onlyTrashed()
                   ->paginate()
        );
    }

    public function restore($id): JsonResponse
    {
        $project = Project::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $project);

        $project->restore();

        return response()->json(['message' => 'Project restored']);
    }

    public function statusList(): JsonResponse
    {
        return response()->json(['data' => Project::$statusList]);
    }

    public function list(): AnonymousResourceCollection
    {
        return ProjectListResource::collection(
            Project::query()
                   ->select(['id', 'title'])
                   ->get()
        );
    }

    public function recentlyAddedTask(): AnonymousResourceCollection
    {
        return ProjectResource::collection(
            Project::query()
                   ->with([
                       'user:id,name,deleted_at',
                       'client:id,company',
                   ])
                   ->withCount(['tasks'])
                   ->orderByDesc(
                       Task::select('id')
                           ->whereColumn('tasks.project_id', 'projects.id')
                           ->orderByDesc('id')
                           ->limit(1)
                   )
                   ->limit(5)
                   ->get()
        );
    }
}
