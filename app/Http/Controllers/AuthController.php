<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfesorDinf;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

        public function login(Request $request)
    {
        $credentials = $request->validate([
            'rut_profesor' => 'required|integer',
            'password' => 'required'
        ]);
        $rut = $credentials['rut_profesor'];

        // Claves de caché por RUT
        $attemptsKey = "login_attempts:{$rut}";
        $lockUntilKey = "login_lock_until:{$rut}";

        // Verificar si está bloqueado
        $lockUntil = Cache::get($lockUntilKey);
        if ($lockUntil) {
            $now = Carbon::now()->timestamp;
            if ($now < $lockUntil) {
                $secondsLeft = $lockUntil - $now;
                return back()->withErrors([
                    'rut_profesor' => "Usuario bloqueado temporalmente."
                ]);
            } else {
                // Bloqueo expiró: limpiar
                Cache::forget($lockUntilKey);
                Cache::forget($attemptsKey);
            }
        }

        // Buscar profesor por RUT
        $profesor = ProfesorDinf::where('rut_profesor', $rut)->first();

        // VERIFICACIÓN SEGURA CON HASH
        if ($profesor && \Illuminate\Support\Facades\Hash::check($credentials['password'], $profesor->password)) {
            // Login exitoso - limpiar intentos y lock, usar guard personalizado
            Cache::forget($attemptsKey);
            Cache::forget($lockUntilKey);

            Auth::guard('web')->login($profesor);
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        // Credenciales inválidas -> incrementar contador
        $attempts = Cache::get($attemptsKey, 0) + 1;
        // Mantener el contador por 3 minutos (ventana de bloqueo)
        Cache::put($attemptsKey, $attempts, now()->addMinutes(3));

        if ($attempts >= 3) {
            // Bloquear por 3 minutos
            $lockFor = 3; // minutos
            $lockUntil = Carbon::now()->addMinutes($lockFor)->timestamp;
            Cache::put($lockUntilKey, $lockUntil, now()->addMinutes($lockFor));
            Cache::forget($attemptsKey);

            return back()->withErrors([
                'rut_profesor' => "Demasiados intentos. Campos bloqueados por {$lockFor} minutos."
            ]);
        }

        return back()->withErrors([
            'rut_profesor' => 'Las credenciales no son válidas.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}