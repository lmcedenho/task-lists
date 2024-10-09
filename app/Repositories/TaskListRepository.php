<?php

namespace App\Repositories;

use App\Models\TaskList;

class TaskListRepository extends BaseRepository
{
    public function __construct(TaskList $taskList)
    {
        parent::__construct($taskList);
    }

    public function withTasks($id)
    {
        return $this->model->with('tasks')->findOrFail($id);
    }
}
