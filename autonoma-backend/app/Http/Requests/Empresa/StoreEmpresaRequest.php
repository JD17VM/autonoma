<?php

namespace App\Http\Requests\Empresa;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmpresaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ¡Importante! Cambiar a true
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'identificador_fiscal' => 'nullable|string|max:50',
            'activo' => 'boolean',
        ];
    }
}