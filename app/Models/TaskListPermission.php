<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskListPermission extends Model
{
    protected $fillable = ['task_list_id', 'user_id', 'can_update', 'can_delete', 'token', 'expires_at'];

    public function taskList()
    {
        return $this->belongsTo(TaskList::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
