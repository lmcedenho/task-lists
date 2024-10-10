<x-app-layout>
    <div class="container mx-auto px-4 mt-10">
        <h2 class="text-2xl font-bold mb-4">Editar Lista de Tareas</h2>
        <div class="bg-white shadow-md rounded-lg p-6">
            <div id="app-vue">
            <task-component 
                :task-list="{{ json_encode($taskList) }}" 
                :existing-tasks="{{ json_encode($existingTasks) }}" 
                :is-editing="true"
                :users="{{ json_encode($users) }}"
                :selected-users="{{ json_encode($selectedUsers) }}" 
            />
            </div>
        </div>
    </div>
</x-app-layout>
