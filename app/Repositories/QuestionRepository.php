<?php

namespace App\Repositories;

use App\Models\Question;
use App\Models\Answer;

class QuestionRepository
{
    public function getAll()
    {
        return Question::all();
    }

    public function findById($id)
    {
        return Question::findOrFail($id);
    }

    public function create(array $data)
    {
        return Question::create([
            'question_text'  => $data['question_text'],
            'answer_correct' => $data['answer_correct'],
            'points'         => $data['points'],
            'image'          => $data['image'] ?? null, // Salva a imagem Base64 no banco
        ]);
    }

    public function store(array $data)
    {
        return Question::create($data);
    }

    public function update($id, array $data)
    {
        $question = Question::findOrFail($id);
        $question->update($data);
        return $question;
    }
    
    public function delete(Question $question)
    {
        return $question->delete();
    }

    public function getRandomForUser($userId)
    {
        return Question::whereNotIn('id', function ($query) use ($userId) {
            $query->select('question_id')
                  ->from('answers')
                  ->where('user_id', $userId);
        })->inRandomOrder()->first();
    }

    public function getAllQuestionsPaginated($perPage = 5)
    {
        return \App\Models\Question::paginate($perPage);
    }

    public function getRandomQuestionForUser(int $userId)
    {
        // Obtém os IDs das perguntas já respondidas pelo usuário
        $answeredIds = Answer::where('user_id', $userId)->pluck('question_id')->toArray();

        // Retorna uma pergunta aleatória que não esteja na lista de respondidas
        return Question::whereNotIn('id', $answeredIds)->inRandomOrder()->first();
    }

}
