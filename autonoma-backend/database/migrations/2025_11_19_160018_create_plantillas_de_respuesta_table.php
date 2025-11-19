<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plantillas_de_respuesta', function (Blueprint $table) {
            $table->id();
            
            // Relaciones
            $table->foreignId('id_canal')->constrained('canales')->onDelete('cascade');
            $table->foreignId('id_etiqueta')->nullable()->constrained('etiquetas')->onDelete('set null');
            
            $table->string('nombre_plantilla', 120);
            $table->string('indicaciones_de_uso', 500)->nullable();
            $table->text('respuesta_exacta');
            
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index('id_canal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plantillas_de_respuesta');
    }
};