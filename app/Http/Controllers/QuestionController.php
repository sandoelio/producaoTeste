<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\QuestionService;

class QuestionController extends Controller {

    protected $questionService;

    public function __construct(QuestionService $questionService) {

        $this->questionService = $questionService;
    }
   
    public function index() {

     $questions = $this->questionService->getAllQuestionsPaginated(5);return view('questions.index', compact('questions'));
    }

    public function store(Request $request) {

        $request->validate([

           'question_text' => 'required|string',
            'answer_correct' => 'required|string',
            'points' => 'required|integer',
            'image' => 'nullable|image|max:2048', // Valida a imagem
        ]);

        $this->questionService->createQuestion($request->all());

        return redirect()->back()->with('success', 'Pergunta criada com sucesso!');
    }

    public function edit($id)
    {
        $question = $this->questionService->getQuestionById($id);
        return view('questions.edit', compact('question'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'question_text'  => 'required',
            'answer_correct' => 'required',
            'points'         => 'required|integer',
            'image'          => 'nullable|image|max:2048',
        ]);

        // Se houver nova imagem, converte para Base64
        if ($request->hasFile('image')) {
            $data['image'] = base64_encode(file_get_contents($request->file('image')->getRealPath()));
        }
        $this->questionService->updateQuestion($id, $data);
        return redirect()->route('questions.index')->with('success', 'Pergunta atualizada com sucesso!');
    }

    public function create()
    {
        return view('questions.create');
    }

    public function destroy($id)
    {
        $question = $this->questionService->getQuestionById($id);
        $question->delete();
        return redirect()->route('questions.index')->with('success', 'Pergunta deletada com sucesso!');
    }

    public function getRandomQuestion($userId)
    {
        // Obtém os IDs das perguntas já respondidas pelo usuário
        $answeredIds = \App\Models\Answer::where('user_id', $userId)->pluck('question_id')->toArray();

        // Retorna uma pergunta aleatória que não esteja na lista de respondidas
        return \App\Models\Question::whereNotIn('id', $answeredIds)->inRandomOrder()->first();
    }

}

