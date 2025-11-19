<?php

namespace App\Http\Requests\PiezaDeConocimiento;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePiezaDeConocimientoRequest extends FormRequest
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
            'titulo' => 'sometimes|string|max:150',
            'contenido' => 'sometimes|string',
            'puntaje_relevancia' => 'integer|min:0|max:100',
            'activo' => 'boolean',
        ];
    }
}