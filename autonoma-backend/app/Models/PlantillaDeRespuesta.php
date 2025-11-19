<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlantillaDeRespuesta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'plantillas_de_respuesta';

    protected $fillable = [
        'id_canal',
        'id_etiqueta',
        'nombre_plantilla',
        'indicaciones_de_uso',
        'respuesta_exacta',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function canal()
    {
        return $this->belongsTo(Canal::class, 'id_canal');
    }

    public function etiqueta()
    {
        return $this->belongsTo(Etiqueta::class, 'id_etiqueta');
    }
}