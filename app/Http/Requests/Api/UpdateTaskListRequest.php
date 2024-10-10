<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskListRequest extends FormRequest
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
            'tasks' => 'nullable|array',
            'users' => 'nullable|array',
        ];
    }

    public function getUsers(): array
    {
        return $this->has('users') ? collect($this->input('users'))->pluck('id')->toArray() : null;
    }
}
