<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ProfesorDinf;
use Illuminate\Support\Facades\Hash;

class MigratePasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passwords:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrar contraseñas existentes a formato cifrado';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔐 Iniciando migración de contraseñas...');
        
        $profesores = ProfesorDinf::all();
        $migrated = 0;
        $alreadyHashed = 0;

        foreach ($profesores as $profesor) {
            // Si la contraseña no está cifrada (no empieza con $2y$)
            if (!preg_match('/^\$2y\$/i', $profesor->password)) {
                // Guardar la contraseña actual para cifrarla
                $plainPassword = $profesor->password;
                $profesor->password = Hash::make($plainPassword);
                $profesor->save();
                $migrated++;
                $this->info("✅ Migrado: {$profesor->rut_profesor} - {$profesor->nombre_profesor}");
            } else {
                $alreadyHashed++;
                $this->line("ℹ️  Ya cifrado: {$profesor->rut_profesor}");
            }
        }

        $this->info("\n🎉 Migración completada!");
        $this->info("📊 Resumen:");
        $this->info("   - Contraseñas migradas: {$migrated}");
        $this->info("   - Ya estaban cifradas: {$alreadyHashed}");
        $this->info("   - Total profesores: {$profesores->count()}");
        
        return Command::SUCCESS;
    }
}