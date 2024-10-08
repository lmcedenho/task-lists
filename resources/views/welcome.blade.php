<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskLists</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-100">

    <!-- Header -->
    <header class="bg-gray-800 shadow-md">
        <div class="container mx-auto px-4 py-6 flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <svg class="h-10 w-auto text-red-400" viewBox="0 0 62 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Your SVG content here -->
                </svg>
                <span class="text-2xl font-bold ml-2 text-red-400">TaskLists</span>
            </div>

            <!-- Navigation -->
            <nav class="flex space-x-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-200 hover:text-gray-400">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-200 hover:text-gray-400">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-gray-200 hover:text-gray-400">Register</a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gray-800 py-20">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold text-gray-100">Organiza tus tareas de manera eficiente</h1>
            <p class="mt-4 text-lg text-gray-300">Crea, edita y comparte listas de tareas con tus colaboradores.</p>
            <div class="mt-8">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-3 bg-red-400 text-white rounded-md shadow-md hover:bg-red-500">Ir al Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-3 bg-red-400 text-white rounded-md shadow-md hover:bg-red-500">Comenzar</a>
                    @endauth
                @endif
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-6 mt-10">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 TaskLists. Todos los derechos reservados.</p>
        </div>
    </footer>

</body>
</html>
