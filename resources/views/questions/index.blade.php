@extends('layouts.app')

@section('title', 'Gerenciamento de Perguntas')

@section('content')
<div class="row">
  <!-- Coluna para inserir nova pergunta -->
  <div class="col-md-12 mb-4">
    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Adicionar Nova Pergunta</h4>
      </div>
      <div class="card-body">
        @if(session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
        @endif

        <form action="{{ route('questions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="question_text" class="form-label">Pergunta:</label>
                <textarea name="question_text" id="question_text" class="form-control" maxlength="150" required></textarea>
                <small class="text-muted">Máximo de 150 caracteres.</small>
            </div>
            <div class="mb-3">
                <label for="answer_correct" class="form-label">Resposta Correta:</label>
                <input type="text" name="answer_correct" id="answer_correct" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="points" class="form-label">Pontuação:</label>
                <input type="number" name="points" id="points" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Imagem (opcional):</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary w-100">Salvar Pergunta</button>
            <br>
            <br>
            <a href="{{ route('report.index') }}" class="btn btn-secondary w-100">Gerar Relatório</a>
            <br>
            <br>
            <a href="{{ route('logout') }}" class="btn btn-danger w-100">Sair</a>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Coluna para listar perguntas -->
<div class="row">
  <div class="col-md-12 mb-4">
    <div class="card shadow-sm">
      <div class="card-header bg-secondary text-white">
        <h4 class="mb-0">Perguntas Cadastradas</h4>
      </div>

      <div class="card-body">
        @if($questions->count() > 0)
        <div class="table-responsive"> <!-- Torna a tabela responsiva -->
          <table class="table table-bordered table-striped">
            <thead class="table-dark">
              <tr>
                <th style="width: 5%;">ID</th>
                <th style="width: 35%;">Pergunta</th>
                <th style="width: 10%;">Pontos</th>
                <th style="width: 20%;">Imagem</th>
                <th style="width: 15%;">Ações</th>
              </tr>
            </thead>
            <tbody>
              @foreach($questions as $question)
                <tr>
                  <td>{{ $question->id }}</td>
                  <td>
                      <span class="short-text text-center d-block mx-auto">{{ Str::limit($question->question_text, 50) }}</span>
                      @if(strlen($question->question_text) > 50)
                          <button class="btn btn-link btn-sm text-primary toggle-text">Ver mais</button>
                          <span class="full-text d-none d-block mx-auto">{!! nl2br(e($question->question_text)) !!}</span>
                      @endif
                  </td>
                  <td>{{ $question->points }}</td>
                  <td>
                    @if($question->image)
                      <img src="data:image/png;base64,{{ $question->image }}" alt="Imagem" class="img-thumbnail" style="max-width:100px; height:auto;">
                    @else
                      <span class="text-muted">Sem imagem</span>
                    @endif
                  </td>
                  <td>
                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning btn-sm w-100 mb-1">Editar</a>
                        <form action="{{ route('questions.destroy', $question->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                        </form>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
          <!-- Paginação -->
          <div class="d-flex justify-content-center">
            {{ $questions->links('vendor.pagination.custom') }}
          </div>
        @else
          <p class="text-center">Nenhuma pergunta cadastrada.</p>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

<style>
    
    .short-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        max-width: 200px;
        text-align: center; /* Centraliza o texto */
    }
    .full-text {
        display: block;
        white-space: normal; /* Permite quebra de linha */
        word-break: break-all; /* Permite quebra de palavras longas */
        width: 200px; /* Largura máxima */
        /* text-align: center; Centraliza o texto */
    }
    .table-responsive {
      overflow-x: auto; /* Permite rolagem horizontal */
      width: 100%;
    }

</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".toggle-text").forEach(function (btn) {
            btn.addEventListener("click", function () {
                const shortText = this.previousElementSibling;
                const fullText = this.nextElementSibling;
                
                if (fullText.classList.contains("d-none")) {
                    fullText.classList.remove("d-none");
                    shortText.classList.add("d-none");
                    this.innerText = "Ver menos";
                } else {
                    fullText.classList.add("d-none");
                    shortText.classList.remove("d-none");
                    this.innerText = "Ver mais";
                }
            });
        });
    });
</script>
