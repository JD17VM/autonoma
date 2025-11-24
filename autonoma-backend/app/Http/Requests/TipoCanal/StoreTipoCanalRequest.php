<?php

namespace App\Http\Requests\TipoCanal;

use Illuminate\Foundation\Http\FormRequest;

class StoreTipoCanalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Permitir a usuarios autenticados
    }

    public function rules(): array
    {
        return [
            'nombre'   => 'required|string|max:50|unique:tipos_canal,nombre',
            'slug'     => 'required|string|max:50|unique:tipos_canal,slug',
            'logo_url' => 'nullable|string', 
            'activo'   => 'boolean',
        ];
    }
}