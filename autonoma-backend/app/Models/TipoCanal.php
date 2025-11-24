<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoCanal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipos_canal';

    protected $fillable = [
        'nombre',    // Ej: WhatsApp, Messenger
        'slug',      // Ej: whatsapp, messenger
        'logo_url',  // URL de la imagen/logo
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Relación: Un Tipo de Canal puede estar asignado a muchos Canales creados.
     */
    public function canales()
    {
        return $this->hasMany(Canal::class, 'id_tipo_canal');
    }
}