<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_empresa' => 'required|exists:empresas,id',
            'id_rol' => 'required|exists:roles,id',
            'nombre_completo' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8', // Mínimo 8 caracteres
            'activo' => 'boolean',
        ];
    }
}