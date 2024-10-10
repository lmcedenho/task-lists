<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detalles de la Lista de Tareas</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Mensaje de error --}}
                    @if (session('error'))
                        <div class="mb-4 p-4 text-red-700 bg-red-100 border border-red-300 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h3 class="text-lg font-semibold">Nombre de la Lista: {{ $taskList->name }}</h3>
                    <p class="text-gray-700">Descripción: {{ $taskList->description }}</p>
                    <p class="text-gray-600">Creado por: {{ $taskList->owner->name }}</p>

                    {{-- Usuarios Asociados --}}
                    <h4 class="mt-6 font-semibold">Usuarios Asociados</h4>
                    @if($taskList->users->isEmpty())
                        <div class="p-4 text-gray-600 bg-gray-100 border border-gray-300 rounded">
                            No hay usuarios asociados a esta lista.
                        </div>
                    @else
                        <ul class="list-disc ml-6">
                            @foreach($taskList->users as $user)
                                <li class="text-gray-700">{{ $user->name }}</li>
                            @endforeach
                        </ul>
                    @endif

                    {{-- Tareas Asociadas --}}
                    <h4 class="mt-6 font-semibold">Tareas Asociadas</h4>
                    @if($taskList->tasks->isEmpty())
                        <div class="p-4 text-gray-600 bg-gray-100 border border-gray-300 rounded">
                            No hay tareas asociadas a esta lista.
                        </div>
                    @else
                        <table class="min-w-full bg-white border border-gray-300 mt-4">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="py-2 px-4 border-b text-left text-gray-600">Título de la Tarea</th>
                                    <!-- <th class="py-2 px-4 border-b text-left text-gray-600">Descripción</th> -->
                                    <!-- <th class="py-2 px-4 border-b text-left text-gray-600">Estado</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($taskList->tasks as $task)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-2 px-4">{{ $task->name }}</td>
                                        <!-- <td class="py-2 px-4">{{ $task->description }}</td> -->
                                        <!-- <td class="py-2 px-4">{{ $task->status }}</td> -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('task-lists.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Volver a la lista</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
