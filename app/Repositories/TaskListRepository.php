<?php

namespace App\Repositories;

use App\Models\TaskList;

class TaskListRepository extends BaseRepository
{
    public function __construct(TaskList $taskList)
    {
        parent::__construct($taskList);
    }
}
