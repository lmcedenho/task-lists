<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Repositories\TaskRepository;
use App\Http\Controllers\Api\TaskController;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DB;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $taskController;
    protected $taskRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->taskRepository = Mockery::mock(TaskRepository::class);
        $this->taskController = new TaskController($this->taskRepository);
    }

    public function testDestroyDeletesTaskSuccessfully()
    {
        $taskId = 1;

        $this->taskRepository->shouldReceive('delete')
            ->once()
            ->with($taskId);

        $response = $this->taskController->destroy($taskId);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Tarea eliminada correctamente.']),
            $response->getContent()
        );
    }

    public function testDestroyHandlesException()
    {
        $taskId = 1;

        $this->taskRepository->shouldReceive('delete')
            ->once()
            ->with($taskId)
            ->andThrow(new \Exception('Error al eliminar la tarea.'));

        $response = $this->taskController->destroy($taskId);

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Error al eliminar la tarea.']),
            $response->getContent()
        );
    }

    protected function tearDown(): void
    {
        // Deshacer la transacción si hay una activa
        DB::rollBack();
        Mockery::close();
        parent::tearDown();
    }
}
