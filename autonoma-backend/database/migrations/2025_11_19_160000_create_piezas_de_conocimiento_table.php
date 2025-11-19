<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('piezas_de_conocimiento', function (Blueprint $table) {
            $table->id();
            
            // Relaciones
            $table->foreignId('id_canal')->constrained('canales')->onDelete('cascade');
            // Si se borra la etiqueta, el campo queda NULL (set null)
            $table->foreignId('id_etiqueta')->nullable()->constrained('etiquetas')->onDelete('set null');
            $table->foreignId('creado_por')->constrained('users')->onDelete('cascade'); 

            $table->string('titulo', 150);
            $table->longText('contenido'); // Markdown extenso
            $table->tinyInteger('puntaje_relevancia')->default(0); // 0 a 100
            
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index('id_canal');
            $table->index('titulo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('piezas_de_conocimiento');
    }
};