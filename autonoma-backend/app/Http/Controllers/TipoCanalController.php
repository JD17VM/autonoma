<?php

namespace App\Http\Controllers;

use App\Models\TipoCanal;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

use App\Http\Requests\TipoCanal\StoreTipoCanalRequest;
use App\Http\Requests\TipoCanal\UpdateTipoCanalRequest;

class TipoCanalController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $tipos = TipoCanal::where('activo', true)->get();
        return $this->success($tipos, 'Catálogo de tipos de canal');
    }

    public function store(StoreTipoCanalRequest $request)
    {
        $tipo = TipoCanal::create($request->validated());
        return $this->success($tipo, 'Tipo de canal creado', 201);
    }

    public function show($id)
    {
        $tipo = TipoCanal::find($id);

        if (!$tipo) {
            return $this->error('Tipo de canal no encontrado', 404);
        }

        return $this->success($tipo, 'Detalle del tipo de canal');
    }

    public function update(UpdateTipoCanalRequest $request, $id)
    {
        $tipo = TipoCanal::find($id);

        if (!$tipo) {
            return $this->error('Tipo de canal no encontrado', 404);
        }

        $tipo->update($request->validated());
        return $this->success($tipo, 'Tipo de canal actualizado');
    }

    public function destroy($id)
    {
        $tipo = TipoCanal::find($id);

        if (!$tipo) {
            return $this->error('Tipo de canal no encontrado', 404);
        }

        if ($tipo->canales()->exists()) {
             return $this->error('No se puede eliminar porque hay canales usando este tipo', 409);
        }

        $tipo->delete();
        return $this->success(null, 'Tipo de canal eliminado');
    }
}