<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

// Importaciones explícitas
use App\Http\Requests\Rol\StoreRolRequest;
use App\Http\Requests\Rol\UpdateRolRequest;

class RolController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $roles = Rol::where('activo', true)->get(); // Solo traemos los activos por defecto
        return $this->success($roles, 'Lista de roles obtenida');
    }

    public function store(StoreRolRequest $request)
    {
        $rol = Rol::create($request->validated());
        return $this->success($rol, 'Rol creado exitosamente', 201);
    }

    public function show($id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return $this->error('Rol no encontrado', 404);
        }

        return $this->success($rol, 'Detalle del rol');
    }

    public function update(UpdateRolRequest $request, $id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return $this->error('Rol no encontrado', 404);
        }

        $rol->update($request->validated());
        return $this->success($rol, 'Rol actualizado correctamente');
    }

    public function destroy($id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return $this->error('Rol no encontrado', 404);
        }

        // Validamos si hay usuarios usando este rol antes de borrar (protección extra a nivel código)
        if ($rol->usuarios()->exists()) {
            return $this->error('No se puede eliminar el rol porque tiene usuarios asignados', 409); // 409 Conflict
        }

        $rol->delete();
        return $this->success(null, 'Rol eliminado permanentemente');
    }
}