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

            $ownerId = auth()->id();

            $taskList = $this->taskListRepository->create([
                'name' => $data['name'],
                'description' => $data['description'],
                'owner_id' => $ownerId,
            ]);

            foreach ($data['tasks'] as $taskData) {
                $taskData['task_list_id'] = $taskList->id;
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
        $existingTasks = $taskList->tasks;

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

            $taskList = $this->taskListRepository->update($id, [
                'name' => $data['name'],
                'description' => $data['description']
            ]);

            $existingTaskIds = $taskList->tasks()->pluck('id')->toArray();
            $updatedTaskIds = collect($data['tasks'])->pluck('id')->toArray();

            foreach ($data['tasks'] as $taskData) {
                $taskData['task_list_id'] = $taskList->id;
                $this->taskRepository->create($taskData);
            }

            return redirect()->route('task-lists.index')->with('success', 'Lista de tareas actualizada correctamente.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar la lista de tareas.')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $taskList = $this->taskListRepository->find($id);
            
            if (!$taskList) {
                return redirect()->route('task-lists.index')->with('error', 'Lista de tareas no encontrada.');
            }

            $this->taskRepository->deleteByTaskListId($id);

            $this->taskListRepository->delete($id);

            return redirect()->route('task-lists.index')->with('success', 'Lista de tareas eliminada correctamente.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar la lista de tareas.')->withInput();
        }
    }
}
