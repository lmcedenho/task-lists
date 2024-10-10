<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TaskList;
use App\Services\TaskListService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use App\Jobs\SendTaskListNotification;

class TaskListControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'sanctum');
    }

    public function test_store_creates_task_list()
    {
        Bus::fake();

        $data = [
            'name' => 'My Task List',
            'tasks' => [
                ['name' => 'First Task'],
                ['name' => 'Second Task'],
            ],
            'users' => [['id' => $this->user->id]]
        ];

        $response = $this->postJson(route('task-lists.store'), $data);

        $response->assertStatus(201)
                ->assertJson([
                    'success' => true,
                    'message' => 'Lista de tareas creada correctamente.',
                ]);

        $this->assertDatabaseHas('task_lists', [
            'name' => 'My Task List',
            'owner_id' => $this->user->id,
        ]);

        Bus::assertDispatched(SendTaskListNotification::class);
    }

    public function test_update_updates_task_list()
    {
        $taskList = TaskList::factory()->create(['owner_id' => $this->user->id]);

        $data = [
            'name' => 'Updated Task List',
            'users' => [['id' => $this->user->id]]
        ];

        $response = $this->putJson(route('task-lists.update', $taskList->id), $data);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Lista de tareas actualizada correctamente.',
                 ]);

        $this->assertDatabaseHas('task_lists', [
            'id' => $taskList->id,
            'name' => 'Updated Task List',
        ]);
    }

    public function test_store_fails_with_validation_error()
    {
        $response = $this->postJson(route('task-lists.store'), []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }

    public function test_update_fails_when_task_list_not_found()
    {
        $response = $this->putJson(route('task-lists.update', 999), [
            'name' => 'Updated Task List',
            'users' => [['id' => $this->user->id]]
        ]);

        $this->assertTrue(
            in_array($response->status(), [400, 500]),
            'Se esperaba un código de estado 400 o 500, pero se recibió: ' . $response->status()
        );
        
        $response->assertJson([
            'success' => false,
            'message' => 'Error al actualizar la lista de tareas.',
        ]);
    }

    public function test_store_fails_on_exception()
    {
        Bus::fake();

        $this->mock(TaskListService::class, function ($mock) {
            $mock->shouldReceive('createTaskList')
                 ->andThrow(new \Exception('Something went wrong'));
        });

        $response = $this->postJson(route('task-lists.store'), [
            'name' => 'My Task List',
            'tasks' => [
                ['name' => 'First Task'],
                ['name' => 'Second Task'],
            ],
            'users' => [['id' => $this->user->id]]
        ]);

        $response->assertStatus(400)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Error al crear la lista de tareas.',
                     'error' => 'Something went wrong',
                 ]);
    }
}
