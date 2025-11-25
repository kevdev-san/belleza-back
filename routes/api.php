<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\MembresiaController;

use App\Services\WhapiService;

Route::get('/test-whapi', function () {
    $whapi = new WhapiService();
    $numero = env('WHATSAPP_DUENO');

    $response = $whapi->enviarMensaje($numero, "🚀 Test exitoso: WHAPI está funcionando!");

    return response()->json([
        'status' => $response->status(),
        'success' => $response->successful(),
        'data' => $response->json()
    ]);
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

//apiresource genera automaticamente todos los metodos get, post, etc
Route::apiResource('citas', CitaController::class);
Route::apiResource('servicios', ServicioController::class);
Route::apiResource('empleados', EmpleadoController::class);
Route::apiResource('membresias', MembresiaController::class);

