<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Canal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'canales';

    protected $fillable = [
        'id_empresa',
        'titulo',
        'tipo',
        'logo_img',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // Relaciones
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function piezas()
    {
        return $this->hasMany(PiezaDeConocimiento::class, 'id_canal');
    }

    public function plantillas()
    {
        return $this->hasMany(PlantillaDeRespuesta::class, 'id_canal');
    }
}