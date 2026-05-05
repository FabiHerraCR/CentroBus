<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('clientes', function (Blueprint $table) {
        $table->id();

        $table->string('nombre', 50);
        $table->string('apellidos', 100);
        $table->string('pasaporte', 30)->unique();
        $table->string('nacionalidad', 50);
        $table->string('correo', 100)->unique();
        $table->string('telefono', 20);

        // Datos de pago para práctica académica.
        // En un sistema real no se debe guardar el CCV.
        $table->string('tarjeta', 30);
        $table->string('ccv', 10);
        $table->date('fecha_vencimiento');

        $table->string('password');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
