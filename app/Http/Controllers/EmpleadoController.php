<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /**
     * Mostrar todos los empleados.
     */
    public function index()
    {
        return response()->json(Empleado::all());
    }

    /**
     * Crear un nuevo empleado.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'especialidad' => 'required|string',
            'salario' => 'required|numeric',
            'fecha_contratacion' => 'required|date',
        ]);

        $empleado = Empleado::create($request->all());

        return response()->json([
            'message' => 'Empleado creado correctamente',
            'empleado' => $empleado
        ], 201);
    }

    /**
     * Mostrar un empleado por ID.
     */
    public function show($id)
    {
        $empleado = Empleado::findOrFail($id);
        return response()->json($empleado);
    }

    /**
     * Actualizar un empleado.
     */
    public function update(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);

        $request->validate([
            'nombre' => 'sometimes|string',
            'especialidad' => 'sometimes|string',
            'salario' => 'sometimes|numeric',
            'fecha_contratacion' => 'sometimes|date',
        ]);

        $empleado->update($request->all());

        return response()->json([
            'message' => 'Empleado actualizado correctamente',
            'empleado' => $empleado
        ]);
    }

    /**
     * Eliminar un empleado.
     */
    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();

        return response()->json([
            'message' => 'Empleado eliminado correctamente'
        ]);
    }
}
