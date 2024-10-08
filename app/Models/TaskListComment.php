<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskListComment extends Model
{
    protected $fillable = ['user_id', 'task_list_id', 'comment'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function taskList()
    {
        return $this->belongsTo(TaskList::class);
    }
}
