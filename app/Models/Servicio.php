<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';
    protected $primaryKey = 'id_servicio';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'duracion',
        'tipo',
    ];

    public function citas()
    {
        return $this->belongsToMany(Cita::class, 'cita_servicio', 'id_servicio', 'id_cita');
    }
}
