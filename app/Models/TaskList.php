<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskList extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'owner_id', 'deleted_by'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'task_list_permissions')
            ->withPivot('can_update', 'can_delete', 'token', 'expires_at')
            ->withTimestamps();
    }

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
