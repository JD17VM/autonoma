<?php

namespace App\Http\Controllers;

use App\Models\PlantillaDeRespuesta;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

// Importaciones explícitas
use App\Http\Requests\PlantillaDeRespuesta\StorePlantillaDeRespuestaRequest;
use App\Http\Requests\PlantillaDeRespuesta\UpdatePlantillaDeRespuestaRequest;

class PlantillaDeRespuestaController extends Controller
{
    use ApiResponser;

    public function index(Request $request)
    {
        // Cargamos canal y etiqueta para contexto
        $query = PlantillaDeRespuesta::with(['canal', 'etiqueta']);

        // Filtro por canal
        if ($request->has('id_canal')) {
            $query->where('id_canal', $request->id_canal);
        }

        $plantillas = $query->get();
        return $this->success($plantillas, 'Lista de plantillas obtenida');
    }

    public function store(StorePlantillaDeRespuestaRequest $request)
    {
        $plantilla = PlantillaDeRespuesta::create($request->validated());
        return $this->success($plantilla, 'Plantilla creada exitosamente', 201);
    }

    public function show($id)
    {
        $plantilla = PlantillaDeRespuesta::with(['canal', 'etiqueta'])->find($id);

        if (!$plantilla) {
            return $this->error('Plantilla no encontrada', 404);
        }

        return $this->success($plantilla, 'Detalle de la plantilla');
    }

    public function update(UpdatePlantillaDeRespuestaRequest $request, $id)
    {
        $plantilla = PlantillaDeRespuesta::find($id);

        if (!$plantilla) {
            return $this->error('Plantilla no encontrada', 404);
        }

        $plantilla->update($request->validated());
        return $this->success($plantilla, 'Plantilla actualizada correctamente');
    }

    public function destroy($id)
    {
        $plantilla = PlantillaDeRespuesta::find($id);

        if (!$plantilla) {
            return $this->error('Plantilla no encontrada', 404);
        }

        $plantilla->delete();
        return $this->success(null, 'Plantilla eliminada');
    }
}