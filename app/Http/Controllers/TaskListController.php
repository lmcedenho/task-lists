<?php

namespace App\Http\Controllers;

use App\Repositories\TaskListRepository;

class TaskListController extends Controller
{
    protected $taskListRepository;

    public function __construct(TaskListRepository $taskListRepository)
    {
        $this->taskListRepository = $taskListRepository;
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
}
