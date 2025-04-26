<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id(); // ID da reserva
            $table->foreignId('sala_id')->constrained('salas')->onDelete('cascade');
            // sala_id ligado à tabela salas, se a sala for deletada, apaga a reserva também
            $table->string('usuario'); // Nome do usuário (por enquanto)
            $table->date('data'); // Data da reserva
            $table->time('horario'); // Horário da reserva
            $table->timestamps(); // created_at e updated_at
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
