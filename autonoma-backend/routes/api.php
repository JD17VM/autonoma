<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\PiezaDeConocimientoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CanalController;
use App\Http\Controllers\EtiquetaController;
use App\Http\Controllers\PlantillaDeRespuestaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas Públicas (por ahora)
Route::apiResource('empresas', EmpresaController::class);
Route::apiResource('piezas', PiezaDeConocimientoController::class);
Route::apiResource('roles', RolController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('canales', CanalController::class);
Route::apiResource('etiquetas', EtiquetaController::class);
Route::apiResource('plantillas', PlantillaDeRespuestaController::class);