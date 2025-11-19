<?php

namespace App\Http\Requests\Etiqueta;

use Illuminate\Foundation\Http\FormRequest;

class StoreEtiquetaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_empresa' => 'required|exists:empresas,id',
            'nombre' => 'required|string|max:100',
            'activo' => 'boolean',
        ];
    }
}