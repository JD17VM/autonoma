<?php

namespace App\Http\Requests\Canal;

use Illuminate\Foundation\Http\FormRequest;

class StoreCanalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_empresa' => 'required|exists:empresas,id',
            'titulo' => 'required|string|max:100', // Ej: "WhatsApp Ventas"
            'id_tipo_canal' => 'required|exists:tipos_canal,id', 
            'activo' => 'boolean',
        ];
    }
}