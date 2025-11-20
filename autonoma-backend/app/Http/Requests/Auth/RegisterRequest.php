<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Datos de relación
            'id_empresa' => 'required|exists:empresas,id',
            'id_rol' => 'required|exists:roles,id',
            
            // Datos personales
            'nombre_completo' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed', // Requiere campo password_confirmation
        ];
    }
}