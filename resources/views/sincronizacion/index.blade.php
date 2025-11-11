<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sincronización - HabilProf</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-semibold">HabilProf - Sincronización</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-900">Cerrar Sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Contenido -->
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-6">Sincronización de Datos</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-blue-800">Gestión Académica</h3>
                            <p class="text-sm text-blue-600">Profesores del DINF</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-green-800">Carga Académica</h3>
                            <p class="text-sm text-green-600">Alumnos inscritos</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-yellow-800">Notas en Línea</h3>
                            <p class="text-sm text-yellow-600">Notas finales</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('sincronizacion.ejecutar') }}">
                        @csrf
                        <button
                            type="submit"
                            class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            Ejecutar Sincronización
                        </button>
                    </form>

                    @if (session('resultados'))
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold mb-4">Resultados de la Sincronización:</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach (session('resultados') as $sistema => $resultado)
                                    <div class="border rounded-lg p-4">
                                        <h4 class="font-semibold capitalize">{{ $sistema }}</h4>
                                        <ul class="text-sm mt-2">
                                            @foreach ($resultado as $key => $value)
                                                <li><span class="capitalize">{{ $key }}:</span> {{ $value }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sección eliminada: Estadísticas del Sistema -->
        </div>
    </div>
</body>
</html>