<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etiquetas', function (Blueprint $table) {
            $table->id();
            
            // Relación con Empresa
            $table->foreignId('id_empresa')->constrained('empresas')->onDelete('cascade');
            
            $table->string('nombre', 100);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            
            // Índices
            $table->index(['id_empresa', 'nombre']); // Índice compuesto para búsquedas
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('etiquetas');
    }
};