<?php

namespace App\Services\SpatieMediaLibrary;

class AddMediaToModel
{

    public function __invoke(array $files, $model, $inputName = 'files')
    {
        foreach ($files as $key => $file) {
            $model
                ->addMediaFromRequest("$inputName" . "[$key]")
                ->usingFileName($file->hashName())
                ->toMediaCollection();
        }
    }
}
