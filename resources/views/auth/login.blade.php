<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HabilProf - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-96">
            <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">
                HabilProf
            </h1>
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    @foreach ($errors->all() as $error)
                        <p class="login-error">{{ $error }}</p>
                    @endforeach
                    <p id="lock-info" class="mt-2 text-sm text-red-800"></p>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                
                <div class="mb-4">
                    <label for="rut_profesor" class="block text-gray-700 text-sm font-bold mb-2">
                        RUT Profesor
                    </label>
                    <input 
                        type="number" 
                        id="rut_profesor" 
                        name="rut_profesor" 
                        value="{{ old('rut_profesor') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                        autofocus
                    >
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                        Contraseña
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                </div>

                <button 
                    type="submit" 
                    id="login-submit"
                    class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    Iniciar Sesión
                </button>
            </form>
        </div>
    </div>
    <script>
        (function(){
            // Buscar mensajes de error y detectar bloqueo
            const errorEls = document.querySelectorAll('.login-error');
            let lockSeconds = null;
            errorEls.forEach(el => {
                const text = (el.textContent || '').trim();
                // Mensaje devuelto por el controlador: "Cuenta bloqueada... X segundos."
                let m = text.match(/(\\d+) segundos/);
                if(m){
                    lockSeconds = parseInt(m[1],10);
                }
                // Mensaje devuelto por el controlador: "Campos bloqueados por X minutos."
                let m2 = text.match(/Acceso temporalmente bloqueado por accesos fallidos/);
                if(m2){
                    lockSeconds = parseInt(m2[1],10) * 60;
                }
            });

            if(lockSeconds && lockSeconds > 0){
                const pwd = document.getElementById('password');
                const submit = document.getElementById('login-submit');
                const info = document.getElementById('lock-info');
                if(pwd) pwd.disabled = true;
                if(submit) submit.disabled = true;

                let remaining = lockSeconds;
                function fmt(s){
                    if(s >= 60){
                        const m = Math.floor(s/60);
                        const sec = s % 60;
                        return `${m}m ${sec}s`;
                    }
                    return `${s}s`;
                }

                info.textContent = `Campos bloqueados por ${fmt(remaining)}.`;
                const iv = setInterval(() => {
                    remaining -= 1;
                    if(remaining <= 0){
                        clearInterval(iv);
                        if(pwd) pwd.disabled = false;
                        if(submit) submit.disabled = false;
                        info.textContent = '';
                    } else {
                        info.textContent = `Campos bloqueados por ${fmt(remaining)}.`;
                    }
                }, 1000);
            }
        })();
    </script>
</body>
</html>