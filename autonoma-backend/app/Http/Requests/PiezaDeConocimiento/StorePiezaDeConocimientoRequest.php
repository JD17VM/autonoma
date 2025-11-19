<?php

namespace App\Http\Requests\PiezaDeConocimiento;

use Illuminate\Foundation\Http\FormRequest;

class StorePiezaDeConocimientoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Permitir acceso
    }

    public function rules(): array
    {
        return [
            'id_canal' => 'required|exists:canales,id',
            'id_etiqueta' => 'nullable|exists:etiquetas,id',
            // Por ahora validamos que envíen el ID del usuario manual
            // (Cuando pongamos login, esto lo tomaremos del token)
            'creado_por' => 'required|exists:users,id', 
            'titulo' => 'required|string|max:150',
            'contenido' => 'required|string', // Markdown permitido
            'puntaje_relevancia' => 'integer|min:0|max:100',
            'activo' => 'boolean',
        ];
    }
}