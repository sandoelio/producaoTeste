<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\QuestionService;
use App\Services\GameService;
use App\Models\User;
use App\Services\UserService;
use App\Models\Answer;


class GameController extends Controller
{
    protected $questionService;
    protected $gameService;
    protected $userService;

    public function __construct(QuestionService $questionService, GameService $gameService, UserService $userService)
    {
        $this->questionService = $questionService;
        $this->gameService = $gameService;
        $this->userService = $userService;
    }

    // Exibe uma pergunta aleatória para o usuário com um timer
    public function index()
    {
        // Verifica se o usuário está logado
        if (!session()->has('usuario_id')) {
            return redirect()->route('form.entrar');
        }

        $userId = session('usuario_id');

        // Se o usuário já respondeu 15 perguntas, redireciona para Game Over
        if ($this->gameService->hasUserCompletedGame($userId)) {
            return redirect()->route('game.over')->with('message', 'Você já respondeu 15 perguntas!');
        }

        // Busca o usuário
        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('form.entrar')->with('error', 'Usuário não encontrado.');
        }
        
        // Obtém uma pergunta aleatória que o usuário ainda não respondeu
        $question = $this->questionService->getRandomQuestionForUser($user->id);
        if (!$question) {
            return redirect()->route('game.over')->with('error', 'Não há mais perguntas disponíveis.');
        }
        
        $currentScore = $user->points;

        return view('game.play', compact('question', 'user', 'currentScore'));
    }

    // Processa a resposta do usuário
    public function submitAnswer(Request $request)
    {
        $request->validate([
            'user_answer'  => 'required|string',
            'question_id'  => 'required|integer',
        ]);

        $userId = session('usuario_id');

        // Chama o service para avaliar a resposta e atualizar a pontuação
        $isCorrect = $this->gameService->evaluateAnswer($request->question_id, $request->user_answer, $userId);

        $message = $isCorrect 
            ? "Resposta correta! Pontuação atualizada." 
            : "Resposta errada! Pontuação atualizada.";

        return redirect()->route('game.index')->with('success', $message);
    }

    public function gameOver()
    {
        // Verifica se o usuário está logado
        if (!session()->has('usuario_id')) {
            return redirect()->route('form.entrar');
        }

        $user = User::find(session('usuario_id'));
        $currentScore = $user ? $user->points : 0;

        return view('game.gameover', compact('currentScore'));
    }

    public function dashboard()
    {
        if (!session()->has('usuario_id')) {
            return redirect()->route('form.entrar');
        }

        $user = User::find(session('usuario_id'));

        if (!$user) {
            return redirect()->route('form.entrar')->with('error', 'Usuário não encontrado.');
        }
   
        // Se o usuário for administrador, redireciona para a área administrativa (gerenciamento de questões)
        if ($user->is_admin) {
            return redirect()->route('questions.index');
        }
        
        // Usa o UserService para obter o ranking dos 10 melhores (excluindo administradores)
        $ranking = $this->userService->getRanking(10);

        return view('game.dashboard', compact('user', 'ranking'));
    }

    public function timeUp()
    {
        if (!session()->has('usuario_id')) {
            return redirect()->route('form.entrar');
        }
    
        $userId = session('usuario_id');
    
        // Buscar a última pergunta do usuário antes do tempo expirar
        $lastAnswer = Answer::where('user_id', $userId)
                            ->latest('created_at') // Pega a última resposta registrada
                            ->first();
    
        $questionId = $lastAnswer ? $lastAnswer->question_id : null;
    
        if (!$questionId) {
            return redirect()->route('game.index')->with('error', 'Nenhuma pergunta encontrada para aplicar penalidade.');
        }
    
        // Aplica a penalidade
        $this->gameService->applyTimePenalty($userId, $questionId);
    
        $user = User::find($userId);
        $currentScore = $user ? $user->points : 0;
    
        return view('game.timeup', compact('currentScore'));
    }
    
     
}