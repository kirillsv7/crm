<?php

namespace App\Http\Requests;

use App\Policies\TaskPolicy;
use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $taskPolicy = new TaskPolicy();
        return match ($this->method()) {
            'POST' => $taskPolicy->create($this->user()),
            'PUT' => $taskPolicy->update($this->user(), $this->route('task')),
            default => false
        };
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title'       => 'required|string',
            'description' => 'required|string',
            'project_id'  => 'required|integer|exists:projects,id',
            'status_id'   => 'required|integer',
            'files'       => 'array',
            'files.*'     => 'file',
        ];
    }

    public function attributes(): array
    {
        return [
            'project_id' => 'project',
            'status_id'  => 'status',
        ];
    }
}
