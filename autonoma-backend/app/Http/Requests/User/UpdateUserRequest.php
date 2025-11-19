<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user'); // Obtenemos el ID de la URL

        return [
            'id_empresa' => 'sometimes|exists:empresas,id',
            'id_rol' => 'sometimes|exists:roles,id',
            'nombre_completo' => 'sometimes|string|max:255',
            // Unique ignorando al usuario actual
            'email' => 'sometimes|email|max:255|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:8', // Opcional al editar
            'activo' => 'boolean',
        ];
    }
}