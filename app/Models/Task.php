<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['task_list_id', 'owner_id', 'name', 'status'];

    public function taskList()
    {
        return $this->belongsTo(TaskList::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
