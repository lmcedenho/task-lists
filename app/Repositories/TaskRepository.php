<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository extends BaseRepository
{
    public function __construct(Task $task)
    {
        parent::__construct($task);
    }

    public function deleteTasks(array $taskIds)
    {
        return $this->model->whereIn('id', $taskIds)->delete();
    }

    public function deleteByTaskListId($taskListId)
    {
        return $this->model->where('task_list_id', $taskListId)->delete();
    }
}
