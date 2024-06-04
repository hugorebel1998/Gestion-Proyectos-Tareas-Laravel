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
        Schema::create('tareas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('proyecto_id');
            $table->uuid('usuario_id');
            $table->string('nombre')->unique();
            $table->string('descripcion');
            $table->string('prioridad');
            $table->string('estatus');
            $table->string('fecha_inicio');
            $table->string('fecha_termino');
            $table->timestamps();
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
