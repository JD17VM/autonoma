<?php

namespace App\Http\Requests\PlantillaDeRespuesta;

use Illuminate\Foundation\Http\FormRequest;

class StorePlantillaDeRespuestaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_canal' => 'required|exists:canales,id',
            'id_etiqueta' => 'nullable|exists:etiquetas,id',
            'nombre_plantilla' => 'required|string|max:120', // Ej: "Despedida Estándar"
            'indicaciones_de_uso' => 'nullable|string|max:500', // Ej: "Usar cuando el cliente dice adiós"
            'respuesta_exacta' => 'required|string', // El texto que se envía al cliente
            'activo' => 'boolean',
        ];
    }
}