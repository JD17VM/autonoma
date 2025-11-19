<?php

namespace App\Http\Requests\Canal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            // Validamos que solo aceptemos estos tipos de canales
            'tipo' => ['required', 'string', Rule::in(['whatsapp', 'facebook', 'instagram', 'web'])],
            'logo_img' => 'nullable|string|max:255', // Por ahora solo string (url)
            'activo' => 'boolean',
        ];
    }
}