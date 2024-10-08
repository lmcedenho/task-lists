<x-app-layout>
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold mb-4">Editar Lista de Tareas</h2>
        <div class="bg-white shadow-md rounded-lg p-6">
            <div id="app-vue">
                <task-component :task-list="{{ json_encode($taskList) }}" :existing-tasks="{{ json_encode($existingTasks) }}" />
            </div>
        </div>
    </div>
</x-app-layout>
