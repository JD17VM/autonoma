<?php

namespace App\Http\Requests\PlantillaDeRespuesta;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlantillaDeRespuestaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_canal' => 'sometimes|exists:canales,id',
            'id_etiqueta' => 'nullable|exists:etiquetas,id',
            'nombre_plantilla' => 'sometimes|string|max:120',
            'indicaciones_de_uso' => 'nullable|string|max:500',
            'respuesta_exacta' => 'sometimes|string',
            'activo' => 'boolean',
        ];
    }
}