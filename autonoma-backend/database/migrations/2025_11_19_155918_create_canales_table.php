<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('canales', function (Blueprint $table) {
            $table->id();
            
            // Relación con Empresa
            $table->foreignId('id_empresa')->constrained('empresas')->onDelete('cascade');
            
            $table->string('titulo', 100); // Ej: WhatsApp Ventas
            $table->string('tipo', 50); // whatsapp, facebook, web
            $table->string('logo_img')->nullable();
            
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index('id_empresa');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('canales');
    }
};