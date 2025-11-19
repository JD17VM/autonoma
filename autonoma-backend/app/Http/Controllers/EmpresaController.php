<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Traits\ApiResponser; // Tu trait para respuestas JSON
use Illuminate\Http\Request;

// Importaciones correctas desde la carpeta Empresa
use App\Http\Requests\Empresa\StoreEmpresaRequest;
use App\Http\Requests\Empresa\UpdateEmpresaRequest;

class EmpresaController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $empresas = Empresa::all();
        return $this->success($empresas, 'Lista de empresas obtenida correctamente');
    }

    public function store(StoreEmpresaRequest $request)
    {
        // El $request ya viene validado gracias a la clase StoreEmpresaRequest
        $empresa = Empresa::create($request->validated());
        return $this->success($empresa, 'Empresa creada exitosamente', 201);
    }

    public function show($id)
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return $this->error('Empresa no encontrada', 404);
        }

        return $this->success($empresa, 'Detalle de la empresa');
    }

    public function update(UpdateEmpresaRequest $request, $id)
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return $this->error('Empresa no encontrada', 404);
        }

        $empresa->update($request->validated());
        return $this->success($empresa, 'Empresa actualizada exitosamente');
    }

    public function destroy($id)
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return $this->error('Empresa no encontrada', 404);
        }

        $empresa->delete(); // Soft Delete
        return $this->success(null, 'Empresa eliminada correctamente');
    }
}