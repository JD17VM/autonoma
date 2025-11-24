<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\PiezaDeConocimientoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TipoCanalController; 
use App\Http\Controllers\CanalController;
use App\Http\Controllers\EtiquetaController;
use App\Http\Controllers\PlantillaDeRespuestaController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (No requieren Token)
|--------------------------------------------------------------------------
*/
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (Requieren 'Bearer Token')
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/profile', [AuthController::class, 'profile']);

    // Módulos de Negocio
    Route::apiResource('empresas', EmpresaController::class);
    Route::apiResource('piezas', PiezaDeConocimientoController::class);
    Route::apiResource('roles', RolController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('tipos-canal', TipoCanalController::class); 
    Route::apiResource('canales', CanalController::class);
    Route::apiResource('etiquetas', EtiquetaController::class);
    Route::apiResource('plantillas', PlantillaDeRespuestaController::class);
});