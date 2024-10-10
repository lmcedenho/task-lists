<?php

namespace App\Jobs;

use App\Models\TaskList;
use App\Notifications\TaskListNotification;
use App\Repositories\UserRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTaskListNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $taskList;
    protected $userIds;
    protected $action;

    public function __construct(TaskList $taskList, array $userIds, string $action)
    {
        $this->taskList = $taskList;
        $this->userIds = $userIds;
        $this->action = $action;
    }

    public function handle(UserRepository $userRepository)
    {
        $chunkSize = 100;

        $userRepository->getUsersByIds($this->userIds)->chunk($chunkSize, function ($usersChunk) {
            foreach ($usersChunk as $user) {
                $user->notify(new TaskListNotification($this->taskList, $this->action));
            }
        });
    }
}
