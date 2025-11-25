<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use App\Services\WhapiService;

class CitaController extends Controller
{
    public function index()
    {
        $citas = Cita::with(['cliente', 'empleado', 'servicios'])->get();
        return response()->json($citas);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_cliente' => 'required|exists:users,id',
            'id_empleado' => 'required|exists:empleados,id_empleado',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'servicios' => 'array',
            'servicios.*' => 'exists:servicios,id_servicio'
        ]);

        $validated['estado'] = 'pendiente';

        // Crear cita
        $cita = Cita::create($validated);

        // Asociar servicios si vienen
        if ($request->has('servicios')) {
            $cita->servicios()->attach($request->servicios);
        }

        // Cargar relaciones
        $cita->load(['cliente', 'empleado', 'servicios']);

        // Intentar enviar notificación por WhatsApp
        $notificacionEnviada = false;
        $errorNotificacion = null;

        $telefonoDueno = env('WHATSAPP_DUENO');

        if ($telefonoDueno) {
            try {
                $whapi = new WhapiService();
                $clienteNombre = $cita->cliente->name;

                // Construir lista de servicios
                $serviciosTexto = $cita->servicios->pluck('nombre')->join(', ');

                $response = $whapi->enviarMensaje(
                    $telefonoDueno,
                    "📅 *Nueva cita registrada*\n\n" .
                    "👤 Cliente: {$clienteNombre}\n" .
                    "💈 Empleado: {$cita->empleado->nombre}\n" .
                    "✂️ Servicios: {$serviciosTexto}\n" .
                    "📆 Fecha: {$cita->fecha}\n" .
                    "⏰ Hora: {$cita->hora}\n\n" .
                    "🆔 Cita #{$cita->id_cita}"
                );

                $notificacionEnviada = $response->successful();

                if (!$notificacionEnviada) {
                    $errorNotificacion = $response->json();
                    \Log::warning('Error al enviar notificación WhatsApp', [
                        'cita_id' => $cita->id_cita,
                        'error' => $errorNotificacion
                    ]);
                }

            } catch (\Exception $e) {
                \Log::error('Excepción al enviar WhatsApp', [
                    'cita_id' => $cita->id_cita,
                    'error' => $e->getMessage()
                ]);
                $errorNotificacion = $e->getMessage();
            }
        }

        return response()->json([
            'message' => 'Cita creada exitosamente',
            'cita' => $cita,
            'notificacion_whatsapp' => [
                'enviada' => $notificacionEnviada,
                'error' => $errorNotificacion
            ]
        ], 201);
    }

    public function show($id)
    {
        $cita = Cita::with(['cliente', 'empleado', 'servicios'])->findOrFail($id);
        return response()->json($cita);
    }

    public function update(Request $request, $id)
    {
        $cita = Cita::findOrFail($id);

        $validated = $request->validate([
            'id_empleado' => 'sometimes|exists:empleados,id_empleado',
            'fecha' => 'sometimes|date',
            'hora' => 'sometimes|date_format:H:i',
            'estado' => 'sometimes|in:pendiente,confirmada,cancelada,completada',
            'servicios' => 'sometimes|array',
            'servicios.*' => 'exists:servicios,id_servicio'
        ]);

        $cita->update($validated);

        if ($request->has('servicios')) {
            $cita->servicios()->sync($request->servicios);
        }

        return response()->json([
            'message' => 'Cita actualizada correctamente',
            'cita' => $cita->load(['cliente', 'empleado', 'servicios'])
        ]);
    }

    public function destroy($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->delete();

        return response()->json([
            'message' => 'Cita eliminada correctamente'
        ]);
    }
}
