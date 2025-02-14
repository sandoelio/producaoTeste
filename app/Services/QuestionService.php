<?php

namespace App\Services;

use App\Repositories\QuestionRepository;
use App\Models\Answer;
use App\Models\Question;

class QuestionService
{
    protected $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function getAllQuestionsPaginated($perPage = 5)
    {
        return $this->questionRepository->getAllQuestionsPaginated($perPage);
    }

    public function createQuestion(array $data)
    {
        if (isset($data['image']) && $data['image']->isValid()) {
                $image = $data['image'];
                $data['image'] = base64_encode(file_get_contents($image->getRealPath())); // Converte para Base64
            } else {
                $data['image'] = null;
            }

        return $this->questionRepository->create($data);

    }

    public function getAllQuestions()
    {
        return $this->questionRepository->getAll();
    }

    public function getQuestionById($id)
    {
        return $this->questionRepository->findById($id);
    }

    public function updateQuestion($id, array $data)
    {
        return $this->questionRepository->update($id, $data);
    }

    // Retorna uma pergunta aleatória para o usuário, se ele já não tiver respondido 15 perguntas
    public function getRandomQuestionForUser($userId)
    {
        return $this->questionRepository->getRandomQuestionForUser($userId);
    }

    public function getRandomQuestion($userId)
{
    // Obtém IDs das perguntas que o usuário já respondeu
    $answeredQuestions = \App\Models\Answer::where('user_id', $userId)->pluck('question_id')->toArray();

    // Seleciona uma nova pergunta que o usuário ainda não respondeu
    return Question::whereNotIn('id', $answeredQuestions)->inRandomOrder()->first();
}


}

