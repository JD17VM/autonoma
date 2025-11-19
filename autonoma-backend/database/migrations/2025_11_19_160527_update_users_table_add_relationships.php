<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 1. Agregamos las claves foráneas
            // Como este archivo tiene fecha de HOY, se ejecutará después de crear 'empresas' y 'roles'
            // por lo tanto, no dará error.
            
            // after('id') sirve para ordenar la columna en la base de datos visualmente
            $table->foreignId('id_empresa')->after('id')->constrained('empresas')->onDelete('cascade');
            $table->foreignId('id_rol')->nullable()->after('id_empresa')->constrained('roles')->onDelete('restrict');

            // 2. Agregamos los campos personalizados de Autonoma
            $table->string('nombre_completo')->after('id_rol');
            $table->boolean('activo')->default(true)->after('password');
            $table->softDeletes()->after('updated_at');

            // 3. Eliminamos el campo 'name' original porque usaremos 'nombre_completo'
            $table->dropColumn('name');
            
            // 4. Agregamos el índice para id_empresa
            $table->index('id_empresa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Si revertimos, borramos lo nuevo y devolvemos el campo 'name'
            $table->dropForeign(['id_empresa']);
            $table->dropForeign(['id_rol']);
            $table->dropColumn(['id_empresa', 'id_rol', 'nombre_completo', 'activo', 'deleted_at']);
            
            $table->string('name')->after('id');
        });
    }
};