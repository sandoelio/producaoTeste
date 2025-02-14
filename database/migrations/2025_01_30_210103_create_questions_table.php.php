<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('question_text'); // Pergunta enigmática
            $table->text('answer_correct'); // Resposta correta
            $table->integer('points')->default(0); // Pontuação associada
            $table->longText('image')->nullable(); // Campo para armazenar a imagem em Base64
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
}
