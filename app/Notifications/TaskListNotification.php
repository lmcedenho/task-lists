<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskListNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $taskList;
    protected $action;
    protected $title;

    public function __construct($taskList, $action)
    {
        $this->taskList = $taskList;
        $this->action = $action;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $subject = $this->action == 'created'
            ? 'Nueva lista de tareas asignada'
            : 'Lista de tareas actualizada';
        
        $title = $this->action == 'created'
            ? 'Se te ha asignado la lista de tareas: '
            : 'Se ha actualizado una lista de tareas: ';

        return (new MailMessage)
                    ->subject($subject)
                    ->line( $title . $this->taskList->name)
                    //->action('Ver Lista', url('/task-lists/' . $this->taskList->id))
                    ->action('Ver Lista', url('/task-lists/' ))
                    ->line('Gracias por usar nuestra aplicación!');
    }
}
