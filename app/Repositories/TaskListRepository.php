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

    public function getUserTaskLists($userId)
    {
        return $this->model->where('owner_id', $userId)
            ->orWhereHas('permissions', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get();
    }

    public function getUserIdsFromTaskList(TaskList $taskList)
    {
        return $taskList->users()->pluck('users.id')->toArray();
    }
}
