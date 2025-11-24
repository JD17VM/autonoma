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
        Schema::create('tipos_canal', function (Blueprint $table) {
            $table->id();
            
            // Campos principales
            $table->string('nombre', 50)->unique(); // Ej: WhatsApp, Messenger
            $table->string('slug', 50)->unique();   // Ej: whatsapp, messenger (para uso interno)
            $table->string('logo_url')->nullable(); // URL o path del icono/logo
            
            // Estado y control
            $table->boolean('activo')->default(true);
            
            $table->timestamps();
            $table->softDeletes(); // Importante: agregamos esto porque tu modelo lo usa
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_canal');
    }
};