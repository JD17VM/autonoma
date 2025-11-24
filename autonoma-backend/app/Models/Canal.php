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
        'id_tipo_canal', // Nuevo campo FK
        'titulo',
        // 'tipo',      // Eliminado: ahora se gestiona vía id_tipo_canal
        // 'logo_img',  // Eliminado: ahora pertenece al TipoCanal
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // --- Relaciones ---

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    /**
     * Relación con el Tipo de Canal (WhatsApp, Messenger, etc.)
     * Permite acceder a: $canal->tipoCanal->nombre o $canal->tipoCanal->logo_url
     */
    public function tipoCanal()
    {
        return $this->belongsTo(TipoCanal::class, 'id_tipo_canal');
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