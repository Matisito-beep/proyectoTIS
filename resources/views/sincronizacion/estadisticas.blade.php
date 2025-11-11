<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas del Sistema - HabilProf</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-semibold">HabilProf - Estadísticas del Sistema</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('sincronizacion') }}" class="text-gray-600 hover:text-gray-900">Sincronización</a>
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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Estadísticas del Sistema</h2>
                        <div class="text-sm text-gray-500">
                            Actualizado: {{ now()->format('d/m/Y H:i') }}
                        </div>
                    </div>

                    <!-- Estadísticas Principales -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-blue-50 p-6 rounded-lg text-center">
                            <div class="text-3xl font-bold text-blue-600">{{ $estadisticas['total_profesores'] }}</div>
                            <div class="text-lg font-semibold text-blue-800">Profesores</div>
                            <div class="text-sm text-blue-600 mt-2">Registrados en el sistema</div>
                        </div>
                        
                        <div class="bg-green-50 p-6 rounded-lg text-center">
                            <div class="text-3xl font-bold text-green-600">{{ $estadisticas['total_alumnos'] }}</div>
                            <div class="text-lg font-semibold text-green-800">Alumnos</div>
                            <div class="text-sm text-green-600 mt-2">Sincronizados del sistema UCSC</div>
                        </div>
                        
                        <div class="bg-purple-50 p-6 rounded-lg text-center">
                            <div class="text-3xl font-bold text-purple-600">{{ $estadisticas['total_habilitaciones'] }}</div>
                            <div class="text-lg font-semibold text-purple-800">Habilitaciones</div>
                            <div class="text-sm text-purple-600 mt-2">Creadas en el sistema</div>
                        </div>
                    </div>

                    <!-- Información Detallada -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Información del Sistema -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4 text-gray-800">Información del Sistema</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Sistema:</span>
                                    <span class="font-medium">HabilProf v1.0</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Framework:</span>
                                    <span class="font-medium">Laravel {{ app()->version() }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">PHP:</span>
                                    <span class="font-medium">{{ PHP_VERSION }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Base de Datos:</span>
                                    <span class="font-medium">SQLite</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Servidor:</span>
                                    <span class="font-medium">{{ request()->server('SERVER_SOFTWARE') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Acciones Rápidas -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4 text-gray-800">Acciones Rápidas</h3>
                            <div class="space-y-3">
                                <a href="{{ route('sincronizacion') }}" class="block w-full bg-blue-500 text-white py-2 px-4 rounded text-center hover:bg-blue-600 transition-colors">
                                    Ejecutar Sincronización
                                </a>
                                <a href="{{ route('habilitaciones.create') }}" class="block w-full bg-green-500 text-white py-2 px-4 rounded text-center hover:bg-green-600 transition-colors">
                                    Crear Nueva Habilitación
                                </a>
                                <a href="{{ route('reportes.estadisticas') }}" class="block w-full bg-purple-500 text-white py-2 px-4 rounded text-center hover:bg-purple-600 transition-colors">
                                    Ver Estadísticas Avanzadas
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen de Datos -->
                    <div class="mt-6 bg-white border border-gray-200 rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Resumen de Datos</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex items-center justify-between p-3 bg-blue-50 rounded">
                                    <span class="text-blue-700">Profesores activos en el sistema</span>
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-bold">
                                        {{ $estadisticas['total_profesores'] }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-green-50 rounded">
                                    <span class="text-green-700">Alumnos disponibles para habilitación</span>
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full font-bold">
                                        {{ $estadisticas['total_alumnos'] }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-purple-50 rounded">
                                    <span class="text-purple-700">Habilitaciones profesionales registradas</span>
                                    <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full font-bold">
                                        {{ $estadisticas['total_habilitaciones'] }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-yellow-50 rounded">
                                    <span class="text-yellow-700">Capacidad del sistema</span>
                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full font-bold">
                                        {{ $estadisticas['total_alumnos'] + $estadisticas['total_profesores'] }} registros
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enlace de regreso -->
                    <div class="mt-6 text-center">
                        <a href="{{ route('sincronizacion') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                            ← Volver a Sincronización
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>