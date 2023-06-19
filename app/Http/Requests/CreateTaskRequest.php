<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'todo_id' => 'required|exists:todo_lists,id',
            'task' => 'required|string',
            'completed' => 'nullable|boolean',
            'previously_completed' => 'nullable|boolean',
            'disabled' => 'nullable|boolean',
            'deadline' => 'nullable|date',
        ];
    }
}
