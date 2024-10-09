<?php

namespace App\Http\Controllers;

use App\Repositories\TaskListRepository;
use App\Repositories\TaskRepository;
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

    public function edit($id)
    {
        $taskList = $this->taskListRepository->find($id);
        $existingTasks = $taskList->tasks;

        return view('task_lists.edit', compact('taskList', 'existingTasks'));
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
