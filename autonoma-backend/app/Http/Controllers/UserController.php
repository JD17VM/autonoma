<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

// Importaciones explícitas
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    use ApiResponser;

    public function index(Request $request)
    {
        // Cargamos la empresa y el rol para que el JSON sea útil
        $query = User::with(['empresa', 'rol']);

        // Filtro opcional por empresa: /api/users?id_empresa=1
        if ($request->has('id_empresa')) {
            $query->where('id_empresa', $request->id_empresa);
        }

        $users = $query->get();
        return $this->success($users, 'Lista de usuarios obtenida');
    }

    public function store(StoreUserRequest $request)
    {
        // Creamos el usuario (el password se hashea automático por el modelo)
        $user = User::create($request->validated());
        
        return $this->success($user, 'Usuario creado exitosamente', 201);
    }

    public function show($id)
    {
        $user = User::with(['empresa', 'rol'])->find($id);

        if (!$user) {
            return $this->error('Usuario no encontrado', 404);
        }

        return $this->success($user, 'Detalle del usuario');
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->error('Usuario no encontrado', 404);
        }

        // validated() solo devuelve los campos que se enviaron.
        // Si no envían password, no se toca el hash existente.
        $user->update($request->validated());
        
        return $this->success($user, 'Usuario actualizado correctamente');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->error('Usuario no encontrado', 404);
        }

        $user->delete(); // Soft Delete
        return $this->success(null, 'Usuario eliminado correctamente');
    }
}