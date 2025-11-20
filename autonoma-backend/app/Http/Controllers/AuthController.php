<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// Importaciones de Requests
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    use ApiResponser;

    /**
     * Login: Recibe credenciales y devuelve Token
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return $this->error('Credenciales incorrectas', 401);
        }

        // Si entra, generamos el token
        $user = User::where('email', $request->email)->first();
        
        // Verificamos si está activo
        if (!$user->activo) {
            return $this->error('Tu cuenta está desactivada', 403);
        }

        // Borramos tokens anteriores para tener sesión única (opcional)
        // $user->tokens()->delete(); 

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->success([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user->load(['empresa', 'rol'])
        ], 'Sesión iniciada correctamente');
    }

    /**
     * Registro: Crea usuario y devuelve Token directo
     */
    public function register(RegisterRequest $request)
    {
        $userData = $request->validated();
        
        // El password se hashea automático en el Modelo, pero Auth::attempt lo requiere limpio
        // Al crear manual, el modelo se encarga.
        
        $user = User::create($userData);

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->success([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 'Usuario registrado exitosamente', 201);
    }

    /**
     * Logout: Elimina el token actual
     */
    public function logout(Request $request)
    {
        // Revoca el token que se usó para esta petición
        $request->user()->currentAccessToken()->delete();

        return $this->success(null, 'Sesión cerrada exitosamente');
    }

    /**
     * Perfil: Devuelve datos del usuario logueado
     */
    public function profile(Request $request)
    {
        return $this->success(
            $request->user()->load(['empresa', 'rol']), 
            'Datos de perfil'
        );
    }
}