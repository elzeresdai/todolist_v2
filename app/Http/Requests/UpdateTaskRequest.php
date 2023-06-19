<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'todo_id' => 'sometimes|required|exists:todo_lists,id',
            'task' => 'sometimes|required|string',
            'completed' => 'sometimes|required|boolean',
            'previously_completed' => 'sometimes|required|boolean',
            'disabled' => 'sometimes|required|boolean',
            'deadline' => 'sometimes|required|date',
        ];
    }
}
