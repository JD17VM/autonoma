<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('canales', function (Blueprint $table) {
            // 1. Eliminar columnas que ya no se necesitan
            $table->dropColumn('tipo');
            $table->dropColumn('logo_img');
            
            // 2. Agregar la nueva clave foránea
            // Esto agregará la columna 'id_tipo_canal' y la enlazará a 'tipos_canal'
            $table->foreignId('id_tipo_canal')
                  ->after('id_empresa') // Colocar después de id_empresa para mejor orden
                  ->constrained('tipos_canal')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('canales', function (Blueprint $table) {
            // 1. Eliminar la clave foránea
            $table->dropForeign(['id_tipo_canal']); 
            $table->dropColumn('id_tipo_canal');
            
            // 2. Recrear las columnas originales (si se hiciera un rollback completo)
            // Esto es importante para que el 'down' sea simétrico.
            $table->string('tipo', 50)->nullable()->after('titulo');
            $table->string('logo_img')->nullable()->after('tipo');
        });
    }
};