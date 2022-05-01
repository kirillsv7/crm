<?php

namespace App\Services;

use App\Models\Project;
use App\Notifications\ProjectAssignedNotification;
use App\Services\SpatieMediaLibrary\AddMediaToModel;
use Illuminate\Support\Arr;

class ProjectService
{
    public function store(array $formData): Project
    {
        $project = Project::create(Arr::except($formData, ['files']));

        if (Arr::exists($formData, 'files')) {
            $addMediaToModel = new AddMediaToModel();
            $addMediaToModel($formData['files'], $project);
        }

        $project->user->notify(new ProjectAssignedNotification($project));

        return $project;
    }

    public function update(Project $project, array $formData): Project
    {
        $project->update(Arr::except($formData, ['files']));

        if (Arr::exists($formData, 'files')) {
            $addMediaToModel = new AddMediaToModel();
            $addMediaToModel($formData['files'], $project);
        }

        if ($project->wasChanged('user_id')) {
            $project->user->notify(new ProjectAssignedNotification($project));
        }

        return $project;
    }
}
