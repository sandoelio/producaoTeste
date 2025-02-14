@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Editar Pergunta</h1>
    
    <form action="{{ route('questions.update', $question->id) }}" method="POST" enctype="multipart/form-data" class="p-4 bg-light rounded shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="question_text" class="form-label">Pergunta:</label>
            <input type="text" id="question_text" name="question_text" class="form-control" value="{{ $question->question_text }}" required>
        </div>

        <div class="mb-3">
            <label for="answer_correct" class="form-label">Resposta Correta:</label>
            <input type="text" id="answer_correct" name="answer_correct" class="form-control" value="{{ $question->answer_correct }}" required>
        </div>

        <div class="mb-3">
            <label for="points" class="form-label">Pontos:</label>
            <input type="number" id="points" name="points" class="form-control" value="{{ $question->points }}" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Imagem (opcional):</label>
            <input type="file" id="image" name="image" class="form-control">
        </div>
        
        @if ($question->image)
            <div class="mb-3">
                <p>Imagem Atual:</p>
                <img src="data:image/png;base64,{{ $question->image }}" class="img-thumbnail" width="200">
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="{{ route('questions.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
