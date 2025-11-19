<?php

namespace App\Http\Requests\Canal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'titulo' => 'sometimes|string|max:100',
            'tipo' => ['sometimes', 'string', Rule::in(['whatsapp', 'facebook', 'instagram', 'web'])],
            'logo_img' => 'nullable|string|max:255',
            'activo' => 'boolean',
        ];
    }
}