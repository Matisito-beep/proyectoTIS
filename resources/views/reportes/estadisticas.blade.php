<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas - HabilProf</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-semibold">HabilProf - Estadísticas Generales</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('reportes.index') }}" class="text-gray-600 hover:text-gray-900">Reportes</a>
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
            <!-- Resumen General -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                    <div class="text-3xl font-bold text-blue-600">{{ $estadisticas['total_habilitaciones'] }}</div>
                    <div class="text-sm text-gray-500 mt-1">Total Habilitaciones</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                    <div class="text-3xl font-bold text-green-600">{{ $estadisticas['total_alumnos'] }}</div>
                    <div class="text-sm text-gray-500 mt-1">Total Alumnos</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                    <div class="text-3xl font-bold text-purple-600">{{ $estadisticas['total_profesores'] }}</div>
                    <div class="text-sm text-gray-500 mt-1">Total Profesores</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                    <div class="text-3xl font-bold text-yellow-600">{{ $estadisticas['profesores_activos'] }}</div>
                    <div class="text-sm text-gray-500 mt-1">Profesores Activos</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Distribución por Tipo -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold mb-4">Distribución por Tipo de Habilitación</h3>
                    <div class="space-y-3">
                        @foreach($estadisticas['por_tipo'] as $tipo => $cantidad)
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">
                                    @switch($tipo)
                                        @case('PrIng') Práctica de Ingeniería @break
                                        @case('PrInv') Proyecto de Investigación @break
                                        @case('PrTut') Práctica Tutelada @break
                                    @endswitch
                                </span>
                                <div class="flex items-center space-x-2">
                                    <div class="w-32 bg-gray-200 rounded-full h-2">
                                        @php
                                            $porcentaje = $estadisticas['total_habilitaciones'] > 0 ? 
                                                ($cantidad / $estadisticas['total_habilitaciones']) * 100 : 0;
                                        @endphp
                                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $porcentaje }}%"></div>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900 w-8">{{ $cantidad }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Habilitaciones por Semestre -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold mb-4">Habilitaciones por Semestre</h3>
                    <div class="space-y-3">
                        @foreach($estadisticas['por_semestre'] as $semestre)
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">
                                    {{ $semestre->semestre_inicio }}-{{ $semestre->anhio }}
                                </span>
                                <div class="flex items-center space-x-2">
                                    <div class="w-32 bg-gray-200 rounded-full h-2">
                                        @php
                                            $porcentaje = $estadisticas['total_habilitaciones'] > 0 ? 
                                                ($semestre->total / $estadisticas['total_habilitaciones']) * 100 : 0;
                                        @endphp
                                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $porcentaje }}%"></div>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900 w-8">{{ $semestre->total }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Estadísticas Detalladas -->
            <div class="mt-6 bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold mb-4">Estadísticas Detalladas</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $estadisticas['alumnos_con_habilitacion'] }}</div>
                        <div class="text-sm text-blue-500">Alumnos con Habilitación</div>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ $estadisticas['total_alumnos'] > 0 ? 
                                round(($estadisticas['alumnos_con_habilitacion'] / $estadisticas['total_alumnos']) * 100, 1) : 0 }}% del total
                        </div>
                    </div>
                    
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $estadisticas['profesores_activos'] }}</div>
                        <div class="text-sm text-green-500">Profesores Activos</div>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ $estadisticas['total_profesores'] > 0 ? 
                                round(($estadisticas['profesores_activos'] / $estadisticas['total_profesores']) * 100, 1) : 0 }}% del total
                        </div>
                    </div>
                    
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        @php
                            $promedio_por_profesor = $estadisticas['profesores_activos'] > 0 ? 
                                round($estadisticas['total_habilitaciones'] / $estadisticas['profesores_activos'], 1) : 0;
                        @endphp
                        <div class="text-2xl font-bold text-purple-600">{{ $promedio_por_profesor }}</div>
                        <div class="text-sm text-purple-500">Promedio por Profesor</div>
                        <div class="text-xs text-gray-500 mt-1">Habilitaciones por profesor activo</div>
                    </div>
                    
                    <div class="text-center p-4 bg-yellow-50 rounded-lg">
                        @php
                            $promedio_por_alumno = $estadisticas['total_alumnos'] > 0 ? 
                                round($estadisticas['total_habilitaciones'] / $estadisticas['total_alumnos'], 1) : 0;
                        @endphp
                        <div class="text-2xl font-bold text-yellow-600">{{ $promedio_por_alumno }}</div>
                        <div class="text-sm text-yellow-500">Promedio por Alumno</div>
                        <div class="text-xs text-gray-500 mt-1">Habilitaciones por alumno</div>
                    </div>
                </div>
            </div>

            <!-- Últimas Habilitaciones -->
            <div class="mt-6 bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold mb-4">Últimas Habilitaciones Registradas</h3>
                @php
                    $ultimasHabilitaciones = \App\Models\HabilitacionProfesional::with('alumno')
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();
                @endphp
                
                @if($ultimasHabilitaciones->count() > 0)
                    <div class="space-y-3">
                        @foreach($ultimasHabilitaciones as $habilitacion)
                            <div class="flex justify-between items-center p-3 border border-gray-200 rounded-lg">
                                <div>
                                    <div class="font-medium">{{ $habilitacion->alumno->nombre_alumno }}</div>
                                    <div class="text-sm text-gray-500">
                                        {{ $habilitacion->semestre_inicio }}-{{ $habilitacion->anhio }} • 
                                        @switch($habilitacion->tipo)
                                            @case('PrIng') Práctica de Ingeniería @break
                                            @case('PrInv') Proyecto de Investigación @break
                                            @case('PrTut') Práctica Tutelada @break
                                        @endswitch
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $habilitacion->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No hay habilitaciones registradas.</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>