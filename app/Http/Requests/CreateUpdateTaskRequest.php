<?php

namespace App\Http\Requests;

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
        return match ($this->method()) {
            'POST'  => $this->user()->isAdmin || $this->user()->hasPermissionTo('task-create'),
            'PUT'   => $this->user()->isAdmin || $this->user()->hasPermissionTo('task-update'),
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
            'new_media'       => 'array',
            'new_media.*'     => 'string|distinct',
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
