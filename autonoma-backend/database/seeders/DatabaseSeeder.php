<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Empresa;
use App\Models\Rol;
use App\Models\User;
use App\Models\TipoCanal;
use App\Models\Canal;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ------------------------------------------------------------------
        // 1. ROLES (Base para AuthController y RolController)
        // ------------------------------------------------------------------
        $rolAdmin = Rol::firstOrCreate(
            ['nombre' => 'Admin'], 
            ['activo' => true]
        );
        
        $rolAgente = Rol::firstOrCreate(
            ['nombre' => 'Agente'], 
            ['activo' => true]
        );

        $this->command->info('Roles creados: Admin y Agente.');

        // ------------------------------------------------------------------
        // 2. EMPRESA PRINCIPAL (Base para EmpresaController)
        // ------------------------------------------------------------------
        $empresa = Empresa::firstOrCreate(
            ['nombre' => 'Autonoma HQ'],
            [
                'activo' => true,
            ]
        );

        $this->command->info('Empresa creada: Autonoma HQ.');

        // ------------------------------------------------------------------
        // 3. TIPOS DE CANAL (Base para TipoCanalController y CanalController)
        // ------------------------------------------------------------------
        $whatsapp = TipoCanal::firstOrCreate(
            ['slug' => 'whatsapp'], 
            ['nombre' => 'WhatsApp', 'activo' => true]
        );
        
        TipoCanal::firstOrCreate(
            ['slug' => 'messenger'], 
            ['nombre' => 'Messenger', 'activo' => true]
        );
        
        TipoCanal::firstOrCreate(
            ['slug' => 'instagram'], 
            ['nombre' => 'Instagram', 'activo' => true]
        );

        $this->command->info('Tipos de Canal cargados.');

        // ------------------------------------------------------------------
        // 4. USUARIO SUPER ADMIN (Para poder hacer Login en AuthController)
        // ------------------------------------------------------------------
        $user = User::firstOrCreate(
            ['email' => 'admin@autonoma.com'],
            [
                'nombre_completo' => 'Super Admin',
                'password' => Hash::make('password123'), // Hash obligatorio
                'id_rol' => $rolAdmin->id,      // Relación requerida
                'id_empresa' => $empresa->id,   // Relación requerida
                'activo' => true                // Crítico para AuthController
            ]
        );

        $this->command->info('Usuario Admin creado: admin@autonoma.com / password123');

        // ------------------------------------------------------------------
        // 5. (OPCIONAL) CANAL DE PRUEBA 
        // Para que cuando entres a /api/canales no salga vacío
        // ------------------------------------------------------------------
        Canal::firstOrCreate(
            ['titulo' => 'WhatsApp Ventas Principal'],
            [
                'id_empresa' => $empresa->id,
                'id_tipo_canal' => $whatsapp->id,
                'activo' => true
            ]
        );

        $this->command->info('Canal de prueba creado.');
    }
}