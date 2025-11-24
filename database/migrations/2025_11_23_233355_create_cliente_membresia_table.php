<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cliente_membresia', function (Blueprint $table) {

            // Cliente = users
            $table->foreignId('id_cliente')
                ->constrained('users', 'id')
                ->onDelete('cascade');

            // Membresía
            $table->foreignId('id_membresia')
                ->constrained('membresias', 'id_membresia')
                ->onDelete('cascade');


            $table->primary(['id_cliente', 'id_membresia']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cliente_membresia');
    }
};
