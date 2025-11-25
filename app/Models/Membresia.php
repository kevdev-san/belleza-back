<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membresia extends Model
{
    protected $table = 'membresias';
    protected $primaryKey = 'id_membresia';

    const TIPOS = [
        'Essencial',
        'Glamour',
        'Luxury',
    ];

    const PRECIOS = [
        'Essencial' => 70,
        'Glamour'   => 200,
        'Luxury'    => 500,
    ];

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
