<?php

namespace App\Http\Requests\TipoCanal;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTipoCanalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('tipos_canal'); 

        return [
            'nombre'   => 'sometimes|string|max:50|unique:tipos_canal,nombre,' . $id,
            'slug'     => 'sometimes|string|max:50|unique:tipos_canal,slug,' . $id,
            'logo_url' => 'nullable|string',
            'activo'   => 'boolean',
        ];
    }
}