<?php

namespace App\Http\Controllers;

use App\Repositories\TaskListRepository;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;

class TaskListController extends Controller
{
    protected $taskListRepository;
    protected $taskRepository;
    protected $userRepository;

    public function __construct(TaskListRepository $taskListRepository, TaskRepository $taskRepository, UserRepository $userRepository)
    {
        $this->taskListRepository = $taskListRepository;
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $userId = auth()->id();
        $taskLists = $this->taskListRepository->getUserTaskLists($userId);
        return view('task_lists.index', compact('taskLists'));
    }

    public function create()
    {
        $users = $this->userRepository->all();
        return view('task_lists.create', compact('users'));
    }

    public function edit($id)
    {
        $taskList = $this->taskListRepository->find($id);
        $existingTasks = $taskList->tasks;
        $users = $this->userRepository->all();
        $selectedUsers = $taskList->users;

        return view('task_lists.edit', compact('taskList', 'existingTasks', 'users', 'selectedUsers'));
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
