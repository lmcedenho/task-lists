<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Listas de Tareas</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Mensaje de éxito --}}
                    @if (session('success'))
                        <div class="mb-4 p-4 text-green-700 bg-green-100 border border-green-300 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Mensaje de error --}}
                    @if (session('error'))
                        <div class="mb-4 p-4 text-red-700 bg-red-100 border border-red-300 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-4">
                        <a href="{{ route('task-lists.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Crear Nueva Lista</a>
                    </div>

                    {{-- Validación para mostrar un mensaje si no hay registros --}}
                    @if($taskLists->isEmpty())
                        <div class="p-4 text-gray-600 bg-gray-100 border border-gray-300 rounded">
                            No hay listas de tareas disponibles.
                        </div>
                    @else
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="py-2 px-4 border-b text-left text-gray-600">Nombre de la Lista</th>
                                    <th class="py-2 px-4 border-b text-left text-gray-600">Descripción</th>
                                    <th class="py-2 px-4 border-b text-left text-gray-600">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($taskLists as $taskList)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-2 px-4">{{ $taskList->name }}</td>
                                        <td class="py-2 px-4">{{ $taskList->description }}</td>
                                        <td class="py-2 px-4 flex space-x-2">
                                            <a href="{{ route('task-lists.edit', $taskList->id) }}" class="text-blue-500 hover:text-blue-700">Editar</a>
                                            <form class="delete-form" action="{{ route('task-lists.destroy', $taskList->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="text-red-500 hover:text-red-700 delete-button">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
