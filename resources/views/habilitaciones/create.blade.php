<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Habilitación - HabilProf</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-semibold">HabilProf - Nueva Habilitación</h1>
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
        <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-6">Ingresar Nueva Habilitación Profesional</h2>
                    
                    <form method="POST" action="{{ route('habilitaciones.store') }}" x-data="habilitacionForm()">
                        @csrf

                        <!-- Información Básica -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Información Básica</h3>
                            
                            <!-- Alumno -->
                            <div class="mb-4">
                                <label for="rut_alumno" class="block text-gray-700 text-sm font-bold mb-2">
                                    Alumno *
                                </label>
                                <select 
                                    id="rut_alumno" 
                                    name="rut_alumno" 
                                    x-model="rutAlumno"
                                    x-on:change="cargarInfoAlumno()"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required
                                >
                                    <option value="">Seleccionar Alumno</option>
                                    @foreach ($alumnos as $alumno)
                                        <option value="{{ $alumno->rut_alumno }}">
                                            {{ $alumno->rut_alumno }} - {{ $alumno->nombre_alumno }}
                                        </option>
                                    @endforeach
                                </select>
                                <div x-show="infoAlumno" class="mt-2 p-2 bg-blue-50 rounded">
                                    <span x-text="infoAlumno"></span>
                                </div>
                            </div>

                            <!-- Tipo de Habilitación -->
                            <div class="mb-4">
                                <label for="tipo_habilitacion" class="block text-gray-700 text-sm font-bold mb-2">
                                    Tipo de Habilitación *
                                </label>
                                <select 
                                    id="tipo_habilitacion" 
                                    name="tipo_habilitacion" 
                                    x-model="tipoHabilitacion"
                                    x-on:change="limpiarCamposPorTipo()"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required
                                >
                                    <option value="">Seleccionar Tipo</option>
                                    <option value="PrIng">Práctica de Ingeniería (PrIng)</option>
                                    <option value="PrInv">Proyecto de Investigación (PrInv)</option>
                                    <option value="PrTut">Práctica Tutelada (PrTut)</option>
                                </select>
                            </div>

                            <!-- Semestre y Año -->
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="semestre_inicio" class="block text-gray-700 text-sm font-bold mb-2">
                                        Semestre *
                                    </label>
                                    <select 
                                        id="semestre_inicio" 
                                        name="semestre_inicio" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        required
                                    >
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="anhio" class="block text-gray-700 text-sm font-bold mb-2">
                                        Año *
                                    </label>
                                    <input 
                                        type="number" 
                                        id="anhio" 
                                        name="anhio" 
                                        value="{{ date('Y') }}"
                                        min="1991" 
                                        max="2050"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        required
                                    >
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div class="mb-4">
                                <label for="descripcion" class="block text-gray-700 text-sm font-bold mb-2">
                                    Descripción del Proyecto *
                                </label>
                                <textarea 
                                    id="descripcion" 
                                    name="descripcion" 
                                    rows="4"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Describa el proyecto o práctica a realizar..."
                                    required
                                ></textarea>
                            </div>
                        </div>

                        <!-- Campos específicos por tipo -->
                        <div x-show="tipoHabilitacion === 'PrIng' || tipoHabilitacion === 'PrInv'" class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Información del Proyecto</h3>
                            <div class="mb-4">
                                <label for="titulo" class="block text-gray-700 text-sm font-bold mb-2">
                                    Título del Proyecto *
                                </label>
                                <input 
                                    type="text" 
                                    x-bind:name="tipoHabilitacion === 'PrIng' ? 'titulo_pring' : 'titulo_prinv'"
                                    x-bind:id="tipoHabilitacion === 'PrIng' ? 'titulo_pring' : 'titulo_prinv'"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Ingrese el título del proyecto..."
                                    x-bind:required="tipoHabilitacion === 'PrIng' || tipoHabilitacion === 'PrInv'"
                                >
                            </div>
                        </div>

                        <div x-show="tipoHabilitacion === 'PrTut'" class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Información de la Empresa</h3>
                            <div class="mb-4">
                                <label for="rut_empresa" class="block text-gray-700 text-sm font-bold mb-2">
                                    Empresa *
                                </label>
                                <select 
                                    id="rut_empresa" 
                                    name="rut_empresa" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    x-bind:required="tipoHabilitacion === 'PrTut'"
                                >
                                    <option value="">Seleccionar Empresa</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->rut_empresa }}">
                                            {{ $empresa->nombre_empresa }} - {{ $empresa->supervi_empresa }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Asignación de Profesores -->
                        <div class="mb-6" x-show="tipoHabilitacion === 'PrIng' || tipoHabilitacion === 'PrInv' || tipoHabilitacion === 'PrTut'">
                            <h3 class="text-lg font-semibold mb-4">Asignación de Profesores</h3>
                            
                            <!-- Profesores para PrIng/PrInv -->
                                <div x-show="tipoHabilitacion === 'PrIng' || tipoHabilitacion === 'PrInv'">
                                <p class="text-sm text-gray-600 mb-4">
                                    <strong>Requeridos:</strong> Profesor Guía y Profesor Comisión<br>
                                    <strong>Opcional:</strong> Profesor Co-Guía
                                </p>
                                
                                @foreach (['Prof_guia' => 'Profesor Guía *', 'Prof_co_guia' => 'Profesor Co-Guía', 'Prof_comision' => 'Profesor Comisión *'] as $tipo => $label)
                                    <div class="mb-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2">
                                            {{ $label }}
                                        </label>
                                        <select 
                                            name="rut_profesor_{{ $tipo }}"
                                            x-model="profesoresSeleccionados['{{ $tipo }}']"
                                            x-on:change="cargarInfoProfesor('{{ $tipo }}')"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            x-bind:required="tipoHabilitacion === 'PrIng' || tipoHabilitacion === 'PrInv'"
                                        >
                                            <option value="">Seleccionar Profesor</option>
                                            @foreach ($profesores as $profesor)
                                                <option value="{{ $profesor->rut_profesor }}">
                                                    {{ $profesor->rut_profesor }} - {{ $profesor->nombre_profesor }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div x-show="infoProfesores['{{ $tipo }}']" class="mt-2 p-2 bg-green-50 rounded">
                                            <span x-text="infoProfesores['{{ $tipo }}']"></span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Profesores para PrTut -->
                            <div x-show="tipoHabilitacion === 'PrTut'">
                                <p class="text-sm text-gray-600 mb-4">
                                    <strong>Requerido:</strong> Profesor Tutor
                                </p>
                                
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                        Profesor Tutor *
                                    </label>
                                    <select 
                                        name="rut_profesor_Prof_tutor"
                                        x-model="profesoresSeleccionados['Prof_tutor']"
                                        x-on:change="cargarInfoProfesor('Prof_tutor')"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        x-bind:required="tipoHabilitacion === 'PrTut'"
                                    >
                                        <option value="">Seleccionar Profesor</option>
                                        @foreach ($profesores as $profesor)
                                            <option value="{{ $profesor->rut_profesor }}">
                                                {{ $profesor->rut_profesor }} - {{ $profesor->nombre_profesor }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div x-show="infoProfesores['Prof_tutor']" class="mt-2 p-2 bg-green-50 rounded">
                                        <span x-text="infoProfesores['Prof_tutor']"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button 
                            type="submit" 
                            class="w-full bg-blue-500 text-white py-3 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            Crear Habilitación
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function habilitacionForm() {
            return {
                tipoHabilitacion: '',
                rutAlumno: '',
                infoAlumno: '',
                profesoresSeleccionados: {
                    'Prof_guia': '',
                    'Prof_co_guia': '',
                    'Prof_tutor': '',
                    'Prof_comision': ''
                },
                infoProfesores: {
                    'Prof_guia': '',
                    'Prof_co_guia': '',
                    'Prof_tutor': '',
                    'Prof_comision': ''
                },

                init() {
                    // Inicializar Alpine.js
                    console.log('Alpine.js inicializado - Tipo:', this.tipoHabilitacion);
                },

                // Función para limpiar campos cuando cambia el tipo
                limpiarCamposPorTipo() {
                    console.log('Cambiando tipo a:', this.tipoHabilitacion);
                    
                    if (this.tipoHabilitacion === 'PrIng') {
                        // Limpiar campos de PrInv y PrTut
                        this.limpiarCampo('titulo_prinv');
                        this.limpiarCampo('rut_empresa');
                    } else if (this.tipoHabilitacion === 'PrInv') {
                        // Limpiar campos de PrIng y PrTut
                        this.limpiarCampo('titulo_pring');
                        this.limpiarCampo('rut_empresa');
                    } else if (this.tipoHabilitacion === 'PrTut') {
                        // Limpiar campos de PrIng y PrInv
                        this.limpiarCampo('titulo_pring');
                        this.limpiarCampo('titulo_prinv');
                    }
                    
                    // Limpiar también selecciones de profesores
                    this.profesoresSeleccionados = {
                        'Prof_guia': '',
                        'Prof_co_guia': '',
                        'Prof_tutor': '',
                        'Prof_comision': ''
                    };
                    this.actualizarOpcionesProfesores();
                },

                // Función auxiliar para limpiar un campo
                limpiarCampo(nombreCampo) {
                    const campo = document.querySelector(`[name="${nombreCampo}"]`);
                    if (campo) {
                        campo.value = '';
                        console.log('Campo limpiado:', nombreCampo);
                    }
                },

                // Función para bloquear profesores ya seleccionados
                actualizarOpcionesProfesores() {
                    const todosLosSelects = document.querySelectorAll('select[name^="rut_profesor_"]');
                    const profesoresSeleccionados = new Set();
                    
                    // Recoger todos los profesores ya seleccionados
                    todosLosSelects.forEach(select => {
                        if (select.value && select.value !== '') {
                            profesoresSeleccionados.add(select.value);
                        }
                    });
                    
                    // Actualizar cada select para deshabilitar opciones ya seleccionadas
                    todosLosSelects.forEach(select => {
                        const options = select.querySelectorAll('option');
                        options.forEach(option => {
                            if (option.value && option.value !== '' && profesoresSeleccionados.has(option.value)) {
                                // Si este profesor ya está seleccionado en OTRO select, deshabilitarlo
                                if (option.value !== select.value) {
                                    option.disabled = true;
                                    option.style.color = '#9CA3AF'; // Color gris
                                    option.style.backgroundColor = '#F3F4F6'; // Fondo gris claro
                                } else {
                                    option.disabled = false;
                                    option.style.color = '';
                                    option.style.backgroundColor = '';
                                }
                            } else {
                                option.disabled = false;
                                option.style.color = '';
                                option.style.backgroundColor = '';
                            }
                        });
                    });
                },

                cargarInfoAlumno() {
                    if (!this.rutAlumno) {
                        this.infoAlumno = '';
                        return;
                    }

                    fetch(`/habilitaciones/alumno-info/${this.rutAlumno}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                this.infoAlumno = 'Alumno no encontrado';
                            } else {
                                this.infoAlumno = `Alumno: ${data.nombre}`;
                            }
                        })
                        .catch(() => {
                            this.infoAlumno = 'Error al cargar información';
                        });
                },

                cargarInfoProfesor(tipo) {
                    const rut = this.profesoresSeleccionados[tipo];
                    
                    // Actualizar opciones de profesores (bloquear duplicados)
                    this.actualizarOpcionesProfesores();
                    
                    if (!rut) {
                        this.infoProfesores[tipo] = '';
                        return;
                    }

                    fetch(`/habilitaciones/profesor-info/${rut}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                this.infoProfesores[tipo] = 'Profesor no encontrado';
                            } else {
                                this.infoProfesores[tipo] = `Profesor: ${data.nombre}`;
                            }
                        })
                        .catch(() => {
                            this.infoProfesores[tipo] = 'Error al cargar información';
                        });
                }
            }
        }
    </script>
</body>
</html>