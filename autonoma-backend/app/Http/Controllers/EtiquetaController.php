<?php

namespace App\Http\Controllers;

use App\Models\Etiqueta;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

// Importaciones explícitas
use App\Http\Requests\Etiqueta\StoreEtiquetaRequest;
use App\Http\Requests\Etiqueta\UpdateEtiquetaRequest;

class EtiquetaController extends Controller
{
    use ApiResponser;

    public function index(Request $request)
    {
        $query = Etiqueta::query();

        // Filtro: ver etiquetas de una empresa
        if ($request->has('id_empresa')) {
            $query->where('id_empresa', $request->id_empresa);
        }

        $etiquetas = $query->get();
        return $this->success($etiquetas, 'Lista de etiquetas obtenida');
    }

    public function store(StoreEtiquetaRequest $request)
    {
        $etiqueta = Etiqueta::create($request->validated());
        return $this->success($etiqueta, 'Etiqueta creada exitosamente', 201);
    }

    public function show($id)
    {
        $etiqueta = Etiqueta::find($id);

        if (!$etiqueta) {
            return $this->error('Etiqueta no encontrada', 404);
        }

        return $this->success($etiqueta, 'Detalle de la etiqueta');
    }

    public function update(UpdateEtiquetaRequest $request, $id)
    {
        $etiqueta = Etiqueta::find($id);

        if (!$etiqueta) {
            return $this->error('Etiqueta no encontrada', 404);
        }

        $etiqueta->update($request->validated());
        return $this->success($etiqueta, 'Etiqueta actualizada correctamente');
    }

    public function destroy($id)
    {
        $etiqueta = Etiqueta::find($id);

        if (!$etiqueta) {
            return $this->error('Etiqueta no encontrada', 404);
        }

        // Opcional: Validar si está en uso antes de borrar, o dejar que el FK set null actúe
        $etiqueta->delete(); 
        return $this->success(null, 'Etiqueta eliminada');
    }
}