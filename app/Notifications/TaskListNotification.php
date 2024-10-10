<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskListNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $taskListData;
    protected $action;
    protected $title;

    public function __construct($taskListData, $action)
    {
        $this->taskListData = $taskListData;
        $this->action = $action;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $name = $this->taskListData['name'] ?? 'name';
        $id = $this->taskListData['id'] ?? 'id';
        switch ($this->action) {
            case 'created':
                $subject = 'Nueva lista de tareas asignada';
                $title = 'Se te ha asignado la lista de tareas: ';
                break;
    
            case 'updated':
                $subject = 'Lista de tareas actualizada';
                $title = 'Se ha actualizado una lista de tareas: ';
                break;
    
            case 'deleted':
                $subject = 'Lista de tareas eliminada';
                $title = 'Se ha eliminado la lista de tareas: ';
                break;
    
            default:
                $subject = 'Acción desconocida en la lista de tareas';
                $title = 'Se ha producido una acción no reconocida.';
                break;
        }
        
        $mailMessage = (new MailMessage)
            ->subject($subject)
            ->line($title . ' ' . $name);

        if ($this->action !== 'deleted') {
            $mailMessage->action('Ver Lista', url('/task-lists/' . $id));
        }
        
        $mailMessage->line('Gracias por usar nuestra aplicación!');
        
        return $mailMessage;
    }
}
