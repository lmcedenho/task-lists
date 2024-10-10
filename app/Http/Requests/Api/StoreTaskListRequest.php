<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskListRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tasks' => 'required|array',
            'tasks.*.name' => 'required|string|max:255',
            'users' => 'nullable|array',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'tasks.required' => 'Se deben proporcionar tareas.',
        ];
    }

    public function getUsers(): array
    {
        return $this->has('users') ? collect($this->input('users'))->pluck('id')->toArray() : null;
    }
}
