<x-app-layout>
    <div class="container mx-auto px-4 mt-10">
        <h2 class="text-2xl font-bold mb-4">Crear Nueva Lista de Tareas</h2>
        <div class="bg-white shadow-md rounded-lg p-6">
            <div id="app-vue">
                <task-component :task-list="{}" :existing-tasks="[]" :is-editing="false"/>
            </div>
        </div>
    </div>
</x-app-layout>
