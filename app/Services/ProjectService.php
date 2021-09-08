<?php

namespace App\Services;

use App\Models\Project;
use App\Services\SpatieMediaLibrary\AddMediaToModel;
use Illuminate\Support\Arr;

class ProjectService
{

    /**
     * @param  array  $formData
     * @return Project
     */
    public function store(array $formData): Project
    {
        $project = Project::create(Arr::except($formData, ['media']));

        if (Arr::exists($formData, 'media')) {
            $addMediaToModel = new AddMediaToModel();
            $addMediaToModel($formData['media'], $project);
        }

        return $project;
    }

    public function update(Project $project, array $formData): Project
    {
        $project->update(Arr::except($formData, ['media']));

        if (Arr::exists($formData, 'media')) {
            $addMediaToModel = new AddMediaToModel();
            $addMediaToModel($formData['media'], $project);
        }

        return $project;
    }
}
