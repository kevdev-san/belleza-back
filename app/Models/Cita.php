<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 'citas';
    protected $primaryKey = 'id_cita';

    protected $fillable = [
        'id_empleado',
        'id_cliente',
        'fecha',
        'hora',
        'estado',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    public function cliente()
    {
        return $this->belongsTo(User::class, 'id_cliente');
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'cita_servicio', 'id_cita', 'id_servicio');
    }
}
