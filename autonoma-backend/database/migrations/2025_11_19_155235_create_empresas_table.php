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
        Schema::create('empresas', function (Blueprint $table) {
            // Clave primaria
            $table->id();
            
            // Campos de datos
            $table->string('nombre');
            $table->string('identificador_fiscal', 50)->nullable();
            
            // Estatus (1 = Activo, 0 = Inactivo)
            $table->boolean('activo')->default(true);
            
            // Timestamps automáticos (created_at, updated_at)
            $table->timestamps();
            
            // Soft Deletes (deleted_at) para no perder historial si se borra
            $table->softDeletes();

            // --- MEJORA: ÍNDICES ---
            // Esto hace que las búsquedas sean instantáneas
            $table->index('nombre'); 
            $table->index('activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};