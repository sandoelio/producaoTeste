<?php

namespace App\Services;

use App\Models\Question;
use App\Models\User;
use App\Models\Answer;
use Illuminate\Support\Facades\DB;
use App\Models\Penalty;


class GameService
{
    /**
     * Avalia a resposta do usuário e atualiza a pontuação.
     *
     * @param int $questionId
     * @param string $userAnswer
     * @param int $userId
     * @return bool Retorna true se a resposta estiver correta, false caso contrário.
     */
    
    public function evaluateAnswer(int $questionId, string $userAnswer, int $userId): bool
    {
        // Busca a pergunta e o usuário
        $question = Question::find($questionId);
        $user = User::find($userId);

        if (!$question || !$user) {
            return false;
        }

        // Compara as respostas de forma case-insensitive e removendo espaços
        $isCorrect = trim(strtolower($question->answer_correct)) === trim(strtolower($userAnswer));

        // Usa uma transação para garantir que a operação seja atômica
        DB::transaction(function () use ($user, $question, $isCorrect, $userAnswer) {
            // Registra a resposta do usuário na tabela 'answers'
            Answer::create([
                'user_id'     => $user->id,
                'question_id' => $question->id,
                'response'    => $userAnswer,
                'is_correct'  => $isCorrect,
            ]);

            // Atualiza os pontos do usuário:
            // Se a resposta estiver correta, soma os pontos da pergunta;
            // Se errada, subtrai 50% dos pontos da pergunta.
            if ($isCorrect) {
                $user->points += $question->points;
            } else {
                $user->points -= round($question->points * 0.5);
            }
            $user->save();
        });

        return $isCorrect;
    }

    public function hasUserCompletedGame(int $userId): bool
    {
        $answeredCount = Answer::where('user_id', $userId)->count();
        return $answeredCount >= 15;
    }

    public function applyTimePenalty(int $userId, int $questionId, int $penalty = 6)
    {
        return DB::transaction(function () use ($userId, $questionId, $penalty) {
            $user = User::find($userId);

            if ($user) {
                $user->points -= $penalty;
                $user->save();

                // Registra a penalidade associada à pergunta
                Penalty::create([
                    'user_id' => $userId,
                    'question_id' => $questionId, // Aqui salvamos a pergunta que expirou
                    'penalty_points' => $penalty,
                    'reason' => 'Tempo expirado',
                ]);
            }
        });
    }

}
