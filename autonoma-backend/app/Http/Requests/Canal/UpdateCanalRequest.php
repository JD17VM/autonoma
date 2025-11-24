<?php

namespace App\Http\Requests\Canal;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCanalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_empresa' => 'sometimes|exists:empresas,id',
            'id_tipo_canal' => 'sometimes|exists:tipos_canal,id', 
            'titulo' => 'sometimes|string|max:100',
            'activo' => 'boolean',
        ];
    }
}