<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskList extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'deleted_by'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function permissions()
    {
        return $this->hasMany(TaskListPermission::class);
    }

    public function comments()
    {
        return $this->hasMany(TaskListComment::class);
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
