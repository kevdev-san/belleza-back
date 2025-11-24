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
        Schema::create('cita_servicio', function (Blueprint $table) {
            // Columnas FK
            $table->foreignId('id_cita')->constrained('citas', 'id_cita')->onDelete('cascade');

            $table->foreignId('id_servicio')->constrained('servicios', 'id_servicio')->onDelete('cascade');

            // Clave primaria compuesta
            $table->primary(['id_cita', 'id_servicio']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cita_servicio');
    }
};
