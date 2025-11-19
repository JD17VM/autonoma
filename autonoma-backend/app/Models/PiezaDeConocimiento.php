<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PiezaDeConocimiento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'piezas_de_conocimiento';

    protected $fillable = [
        'id_canal',
        'id_etiqueta',
        'creado_por',
        'titulo',
        'contenido',
        'puntaje_relevancia',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'puntaje_relevancia' => 'integer',
    ];

    // Relaciones
    public function canal()
    {
        return $this->belongsTo(Canal::class, 'id_canal');
    }

    public function etiqueta()
    {
        return $this->belongsTo(Etiqueta::class, 'id_etiqueta');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
}