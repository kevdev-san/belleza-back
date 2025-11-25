<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * Mostrar todos los servicios.
     */
    public function index()
    {
        $servicios = Servicio::all();
        return response()->json($servicios);
    }

    /**
     * Crear un nuevo servicio.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'duracion' => 'required|date_format:H:i:s',
            'tipo' => 'required|in:corte,tinte,spa,peinado',
        ]);

        $servicio = Servicio::create($validated);

        return response()->json([
            'message' => 'Servicio creado correctamente',
            'data' => $servicio
        ], 201);
    }

    /**
     * Mostrar un servicio por ID.
     */
    public function show($id)
    {
        $servicio = Servicio::findOrFail($id);
        return response()->json($servicio);
    }

    /**
     * Actualizar un servicio.
     */
    public function update(Request $request, $id)
    {
        $servicio = Servicio::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string',
            'precio' => 'sometimes|numeric|min:0',
            'duracion' => 'sometimes|date_format:H:i:s',
            'tipo' => 'sometimes|in:corte,tinte,spa,peinado',
        ]);

        $servicio->update($validated);

        return response()->json([
            'message' => 'Servicio actualizado correctamente',
            'data' => $servicio
        ]);
    }

    /**
     * Eliminar un servicio.
     */
    public function destroy($id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->delete();

        return response()->json([
            'message' => 'Servicio eliminado correctamente'
        ]);
    }
}
