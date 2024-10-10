<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\StoreTaskListRequest;
use App\Http\Requests\Api\UpdateTaskListRequest;
use App\Http\Controllers\Controller;
use App\Services\TaskListService;
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
        try {
            $data = $request->validated();
            $ownerId = auth()->id();
    
            $taskList = $this->taskListService->createTaskList($data, $ownerId);

            if ($request->has('users')) {
                $taskList->users()->sync($request->getUsers());
            }
    
            return response()->json([
                'message' => 'Lista de tareas creada correctamente.',
                'task_list' => $taskList,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al crear la lista de tareas.',
                'details' => $e->getMessage(),
            ], 400);
        }
    }

    public function update(UpdateTaskListRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $taskList = $this->taskListService->updateTaskList($id, $data);

            if ($request->has('users')) {
                $taskList->users()->sync($request->getUsers());
            }

            return response()->json([
                'success' => true,
                'message' => 'Lista de tareas actualizada correctamente.',
                'data' => $taskList,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la lista de tareas.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
