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
        Schema::create('tarea_comentarios', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tarea_id');
            $table->uuid('usuario_id');
            $table->string('comentario');
            $table->timestamps();
            $table->foreign('tarea_id')->references('id')->on('tareas')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarea_comentarios');
    }
};
