<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\StoreTaskListRequest;
use App\Http\Requests\Api\UpdateTaskListRequest;
use App\Http\Controllers\Controller;
use App\Services\TaskListService;
use App\Jobs\SendTaskListNotification;
use Exception;

class TaskListController extends Controller
{
    protected $taskListService;

    public function __construct(TaskListService $taskListService)
    {
        $this->taskListService = $taskListService;
    }

    public function store(StoreTaskListRequest $request)
    {
        return $this->handleTaskList($request, 'created');
    }

    public function update(UpdateTaskListRequest $request, $id)
    {
        return $this->handleTaskList($request, 'updated', $id);
    }

    private function handleTaskList($request, $action, $id = null)
    {
        try {
            $data = $request->validated();
            $ownerId = auth()->id();

            if ($action === 'created') {
                $taskList = $this->taskListService->createTaskList($data, $ownerId);
            } else {
                $taskList = $this->taskListService->updateTaskList($id, $data);
            }

            $notificationData = [
                'id' => $taskList->id,
                'name' => $taskList->name
            ];

            if ($request->has('users')) {
                $users = $request->getUsers();
                $this->taskListService->assignUsersToTaskList($taskList, $users);
                SendTaskListNotification::dispatch($notificationData, $users, $action);
            }

            return response()->json([
                'success' => true,
                'message' => $action === 'created' ? 'Lista de tareas creada correctamente.' : 'Lista de tareas actualizada correctamente.',
                'data' => $taskList,
            ], $action === 'created' ? 201 : 200);
        } catch (Exception $e) {
            \Log::error('Error creating/updating task list: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $action === 'created' ? 'Error al crear la lista de tareas.' : 'Error al actualizar la lista de tareas.',
                'error' => $e->getMessage(),
            ], $action === 'created' ? 400 : 500);
        }
    }
}
