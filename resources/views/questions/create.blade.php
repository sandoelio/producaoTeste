@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Adicionar Nova Pergunta</h2>

    <form action="{{ route('questions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="question_text" class="form-label">Pergunta</label>
            <input type="text" name="question_text" id="question_text" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="answer_correct" class="form-label">Resposta Correta</label>
            <input type="text" name="answer_correct" id="answer_correct" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="points" class="form-label">Pontuação</label>
            <input type="number" name="points" id="points" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Imagem (opcional)</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Salvar Pergunta</button>
        <a href="{{ route('questions.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
