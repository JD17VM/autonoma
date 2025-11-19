<?php

namespace App\Http\Requests\Etiqueta;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEtiquetaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_empresa' => 'sometimes|exists:empresas,id',
            'nombre' => 'sometimes|string|max:100',
            'activo' => 'boolean',
        ];
    }
}