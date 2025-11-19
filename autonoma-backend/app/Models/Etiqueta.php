<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_empresa',
        'nombre',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }
}