<?php

namespace App\Http\Controllers;

use App\Models\Canal;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

// Importaciones explícitas
use App\Http\Requests\Canal\StoreCanalRequest;
use App\Http\Requests\Canal\UpdateCanalRequest;

class CanalController extends Controller
{
    use ApiResponser;

    public function index(Request $request)
    {
        $query = Canal::with('empresa');

        // Filtro útil: Obtener solo los canales de una empresa específica
        if ($request->has('id_empresa')) {
            $query->where('id_empresa', $request->id_empresa);
        }

        $canales = $query->get();
        return $this->success($canales, 'Lista de canales obtenida');
    }

    public function store(StoreCanalRequest $request)
    {
        $canal = Canal::create($request->validated());
        return $this->success($canal, 'Canal creado exitosamente', 201);
    }

    public function show($id)
    {
        $canal = Canal::with('empresa')->find($id);

        if (!$canal) {
            return $this->error('Canal no encontrado', 404);
        }

        return $this->success($canal, 'Detalle del canal');
    }

    public function update(UpdateCanalRequest $request, $id)
    {
        $canal = Canal::find($id);

        if (!$canal) {
            return $this->error('Canal no encontrado', 404);
        }

        $canal->update($request->validated());
        return $this->success($canal, 'Canal actualizado correctamente');
    }

    public function destroy($id)
    {
        $canal = Canal::find($id);

        if (!$canal) {
            return $this->error('Canal no encontrado', 404);
        }

        $canal->delete(); // Soft delete
        return $this->success(null, 'Canal eliminado correctamente');
    }
}