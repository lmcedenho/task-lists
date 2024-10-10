<?php

namespace App\Repositories;

use App\Models\TaskListPermission;

class TaskListPermissionRepository extends BaseRepository
{
    public function __construct(TaskListPermission $permission)
    {
        parent::__construct($permission);
    }
}
