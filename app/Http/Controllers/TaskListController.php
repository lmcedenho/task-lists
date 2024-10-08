<?php

namespace App\Http\Controllers;

use App\Repositories\TaskListRepository;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Exception;

class TaskListController extends Controller
{
    protected $taskListRepository;
    protected $taskRepository;

    public function __construct(TaskListRepository $taskListRepository, TaskRepository $taskRepository)
    {
        $this->taskListRepository = $taskListRepository;
        $this->taskRepository = $taskRepository;
    }

    public function index()
    {
        $taskLists = $this->taskListRepository->all();
        return view('task_lists.index', compact('taskLists'));
    }

    public function create()
    {
        // No es necesario cargar tareas aquí
        return view('task_lists.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'tasks' => 'required|array',
                'tasks.*.name' => 'required|string|max:255',
            ]);

            // Obtener el ID del usuario autenticado
            $ownerId = auth()->id();

            // Crear la lista de tareas
            $taskList = $this->taskListRepository->create([
                'name' => $data['name'],
                'description' => $data['description'],
                'owner_id' => $ownerId, // Asigna el owner_id del usuario autenticado
            ]);

            // Asignar las tareas a la lista
            foreach ($data['tasks'] as $taskData) {
                $taskData['task_list_id'] = $taskList->id;
                $taskData['owner_id'] = $ownerId; // Asigna el owner_id a cada tarea
                $this->taskRepository->create($taskData);
            }

            return redirect()->route('task-lists.index')->with('success', 'Lista de tareas creada correctamente.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al crear la lista de tareas.')->withInput();
        }
    }

    public function edit($id)
    {
        $taskList = $this->taskListRepository->find($id);
        $existingTasks = $taskList->tasks; // Obtener las tareas existentes

        return view('task_lists.edit', compact('taskList', 'existingTasks'));
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'tasks' => 'required|array',
                'tasks.*.name' => 'required|string|max:255',
            ]);

            // Obtener el ID del usuario autenticado
            $ownerId = auth()->id();

            // Actualizar la lista de tareas
            $taskList = $this->taskListRepository->update($id, [
                'name' => $data['name'],
                'description' => $data['description'],
                'owner_id' => $ownerId, // Actualiza el owner_id de la lista de tareas
            ]);

            // Eliminar las tareas actuales
            $taskList->tasks()->delete();
            // Crear las nuevas tareas
            foreach ($data['tasks'] as $taskData) {
                $taskData['task_list_id'] = $taskList->id;
                $taskData['owner_id'] = $ownerId; // Asigna el owner_id a cada tarea
                $this->taskRepository->create($taskData);
            }

            return redirect()->route('task-lists.index')->with('success', 'Lista de tareas actualizada correctamente.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar la lista de tareas.')->withInput();
        }
    }
}
