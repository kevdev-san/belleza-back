<?php

namespace App\Http\Controllers;

use App\Models\Membresia;
use Illuminate\Http\Request;

class MembresiaController extends Controller
{
    /**
     * Mostrar todas las membresías.
     */
    public function index()
    {
        return response()->json(Membresia::all());
    }

    /**
     * Crear una nueva membresía.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|in:Essencial,Glamour,Luxury',
            'beneficios' => 'required|string',
        ]);

        // Obtener el precio según el tipo de membresía
        $costo = Membresia::PRECIOS[$request->nombre];

        $membresia = Membresia::create([
            'nombre' => $request->nombre,
            'costo' => $costo,
            'beneficios' => $request->beneficios,
        ]);

        return response()->json([
            'message' => 'Membresía creada correctamente',
            'membresia' => $membresia
        ], 201);
    }

    /**
     * Mostrar una membresía por ID.
     */
    public function show($id)
    {
        $membresia = Membresia::findOrFail($id);
        return response()->json($membresia);
    }

    /**
     * Actualizar una membresía.
     */
    public function update(Request $request, $id)
    {
        $membresia = Membresia::findOrFail($id);

        $request->validate([
            'nombre' => 'sometimes|in:Essencial,Glamour,Luxury',
            'beneficios' => 'sometimes|string',
        ]);

        // Si cambia el nombre, recalcular el costo
        if ($request->has('nombre')) {
            $membresia->costo = Membresia::PRECIOS[$request->nombre];
        }

        $membresia->update($request->only('nombre', 'beneficios'));

        return response()->json([
            'message' => 'Membresía actualizada correctamente',
            'membresia' => $membresia
        ]);
    }

    /**
     * Eliminar una membresía.
     */
    public function destroy($id)
    {
        $membresia = Membresia::findOrFail($id);
        $membresia->delete();

        return response()->json([
            'message' => 'Membresía eliminada correctamente'
        ]);
    }
}
