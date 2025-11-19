<?php

namespace App\Http\Controllers;

use App\Models\PiezaDeConocimiento;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

// Importaciones explícitas de la carpeta correcta
use App\Http\Requests\PiezaDeConocimiento\StorePiezaDeConocimientoRequest;
use App\Http\Requests\PiezaDeConocimiento\UpdatePiezaDeConocimientoRequest;

class PiezaDeConocimientoController extends Controller
{
    use ApiResponser;

    public function index(Request $request)
    {
        // Iniciamos la consulta cargando las relaciones para que el JSON venga completo
        // (Trae datos del canal, la etiqueta y quién lo creó)
        $query = PiezaDeConocimiento::with(['canal', 'etiqueta', 'creador']);

        // Filtro opcional: /api/piezas?id_canal=1
        if ($request->has('id_canal')) {
            $query->where('id_canal', $request->id_canal);
        }

        // Filtro opcional: /api/piezas?buscar=texto
        if ($request->has('buscar')) {
            $query->where('titulo', 'like', '%' . $request->buscar . '%');
        }

        $piezas = $query->get();
        
        return $this->success($piezas, 'Listado de piezas de conocimiento');
    }

    public function store(StorePiezaDeConocimientoRequest $request)
    {
        $pieza = PiezaDeConocimiento::create($request->validated());
        return $this->success($pieza, 'Pieza creada exitosamente', 201);
    }

    public function show($id)
    {
        $pieza = PiezaDeConocimiento::with(['canal', 'etiqueta', 'creador'])->find($id);

        if (!$pieza) {
            return $this->error('Pieza no encontrada', 404);
        }

        return $this->success($pieza, 'Detalle de pieza');
    }

    public function update(UpdatePiezaDeConocimientoRequest $request, $id)
    {
        $pieza = PiezaDeConocimiento::find($id);

        if (!$pieza) {
            return $this->error('Pieza no encontrada', 404);
        }

        $pieza->update($request->validated());
        return $this->success($pieza, 'Pieza actualizada correctamente');
    }

    public function destroy($id)
    {
        $pieza = PiezaDeConocimiento::find($id);

        if (!$pieza) {
            return $this->error('Pieza no encontrada', 404);
        }

        $pieza->delete();
        return $this->success(null, 'Pieza eliminada correctamente');
    }
}