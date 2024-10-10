<?php

namespace App\Http\Controllers\Api;

use App\Repositories\TaskRepository;
use App\Http\Controllers\Controller;
use Exception;

class TaskController extends Controller
{
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function destroy($id)
    {
        try {
            $this->taskRepository->delete($id);
            return response()->json(['message' => 'Tarea eliminada correctamente.'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error al eliminar la tarea.'], 500);
        }
    }
}
