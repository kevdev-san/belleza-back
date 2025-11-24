<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id('id_cita');

            $table->foreignId('id_empleado')->constrained('empleados', 'id_empleado'); //tabla a la que se hace referencia y la columna
            $table->foreignId('id_cliente')->constrained('users');

            $table->date('fecha');
            $table->time('hora');
            $table->string('estado')->default('pendiente');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
