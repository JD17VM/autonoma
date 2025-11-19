<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'identificador_fiscal',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // Relaciones
    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_empresa');
    }

    public function canales()
    {
        return $this->hasMany(Canal::class, 'id_empresa');
    }

    public function etiquetas()
    {
        return $this->hasMany(Etiqueta::class, 'id_empresa');
    }
}