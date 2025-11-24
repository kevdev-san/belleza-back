<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';
    protected $primaryKey = 'id_empleado';

    protected $fillable = [
        'nombre',
        'especialidad',
        'salario',
        'fecha_contratacion',
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class, 'id_empleado');
    }
}
