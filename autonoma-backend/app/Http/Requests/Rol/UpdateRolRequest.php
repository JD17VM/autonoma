<?php

namespace App\Http\Requests\Rol;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Obtenemos el ID del rol desde la ruta para la validación unique
        $rolId = $this->route('rol'); 

        return [
            'nombre' => 'sometimes|required|string|max:50|unique:roles,nombre,' . $rolId,
            'descripcion' => 'nullable|string|max:255',
            'activo' => 'boolean',
        ];
    }
}