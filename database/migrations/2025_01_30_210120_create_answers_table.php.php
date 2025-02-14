<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');; // Relacionamento com a tabela de users
            $table->foreignId('question_id')->constrained('questions'); // Relacionamento com a tabela de questions
            $table->text('response'); // Resposta dada pelo usuário
            $table->boolean('is_correct')->default(false); // Se a resposta foi correta ou não
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
}
