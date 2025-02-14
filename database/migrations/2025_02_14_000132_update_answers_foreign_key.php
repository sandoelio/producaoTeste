<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->dropForeign(['question_id']); // Remove a chave estrangeira atual
            $table->foreign('question_id')
                ->references('id')->on('questions')
                ->onDelete('cascade'); // Adiciona com CASCADE

        });
    }

    public function down(): void
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->dropForeign(['question_id']);
            $table->foreign('question_id')->references('id')->on('questions');
        });
    }
};