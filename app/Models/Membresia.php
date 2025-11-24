<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membresia extends Model
{
    protected $table = 'membresias';
    protected $primaryKey = 'id_membresia';

    protected $fillable = [
        'nombre',
        'costo',
        'beneficios',
    ];

    public function clientes()
    {
        return $this->belongsToMany(User::class, 'cliente_membresia', 'id_membresia', 'id_cliente');
    }
}
