<?php

namespace App\Services;

use App\Repositories\TaskListRepository;
use App\Repositories\TaskRepository;

class TaskListService
{
    protected $taskListRepository;
    protected $taskRepository;

    public function __construct(TaskListRepository $taskListRepository, TaskRepository $taskRepository)
    {
        $this->taskListRepository = $taskListRepository;
        $this->taskRepository = $taskRepository;
    }

    public function createTaskList(array $data, int $ownerId)
    {
        $taskList = $this->taskListRepository->create([
            'name' => $data['name'],
            'description' => $data['description'],
            'owner_id' => $ownerId,
        ]);

        foreach ($data['tasks'] as $taskData) {
            $taskData['task_list_id'] = $taskList->id;
            $this->taskRepository->create($taskData);
        }

        return $taskList;
    }

    public function updateTaskList($id, array $data)
    {
        $taskList = $this->taskListRepository->update($id, [
            'name' => $data['name'],
            'description' => $data['description']
        ]);

        if (isset($data['tasks'])) {
            foreach ($data['tasks'] as $taskData) {
                $taskData['task_list_id'] = $taskList->id;
                $this->taskRepository->create($taskData);
            }
        }

        return $taskList;
    }
}
