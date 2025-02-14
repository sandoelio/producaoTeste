@extends('layouts.app')

@section('title', 'Relatório de Usuários')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">📊 Relatório de Usuários</h2>

    @if(count($reportData) > 0)
        <div class="card shadow-sm p-3">
            <div class="card-body">
                <div class="table-responsive"> <!-- Tabela responsiva -->
                    <table class="table table-hover table-bordered text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Usuário</th>
                                <th>Pontuação</th>
                                <th>Perguntas e Respostas</th>
                                <th>Punições</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reportData as $data)
                            <tr>
                                <td><strong>{{ $data['ranking'] }}</strong></td>
                                <td>{{ $data['name'] }}</td>
                                <td>
                                    <span class="badge bg-primary fs-6">{{ $data['points'] }} pts</span>
                                </td>
                                <td class="text-start">
                                    @if($data['answers']->count() > 0)
                                        <ul class="list-group list-group-flush">
                                            @foreach($data['answers'] as $answer)
                                                <li class="list-group-item">
                                                    <strong>P:</strong> 
                                                    <span class="short-text">
                                                        {{ Str::limit($answer->question->question_text ?? 'N/A', 50) }}
                                                    </span>
                                                    <pre class="full-text d-none">{{ $answer->question->question_text ?? 'N/A' }}</pre>
                                                    @if(strlen($answer->question->question_text ?? '') > 50)
                                                        <a href="#" class="toggle-text">Ver mais...</a>
                                                    @endif
                                                    <br>
                                                    <strong>R:</strong> 
                                                    <span class="short-text">
                                                        {{ Str::limit($answer->response, 50) }}
                                                    </span>
                                                    <pre class="full-text d-none">{{ $answer->response }}</pre>
                                                    @if(strlen($answer->response) > 50)
                                                        <a href="#" class="toggle-text">Ver mais...</a>
                                                    @endif
                                                    @if($answer->is_correct)
                                                        <span class="badge bg-success">✔ Correta</span>
                                                    @else
                                                        <span class="badge bg-danger">❌ Errada</span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted">Sem respostas registradas</span>
                                    @endif
                                </td>
                                <td class="text-start">
                                    @if($data['penalties']->count() > 0)
                                        <ul class="list-group list-group-flush">
                                            @foreach($data['penalties'] as $penalty)
                                                <li class="list-group-item text-danger">
                                                    <strong>🆔 Pergunta:</strong> {{ $penalty->question_id }}<br>
                                                    <strong>🔻 Penalidade:</strong> 
                                                    <span class="badge bg-danger">{{ $penalty->penalty_points }} pts</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted">Sem punições aplicadas</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- Fim table-responsive -->
            </div>
        </div>
    @else
        <div class="alert alert-warning text-center">
            Nenhum dado disponível para exibição.
        </div>
    @endif
</div>

<!-- Botão de voltar -->
<div class="container mt-3 mb-4 text-center">
    <a href="{{ route('questions.index') }}" class="btn btn-secondary px-5 py-2">🔙 Voltar</a>
</div>

{{-- CSS Personalizado --}}
<style>
    .table-responsive {
        overflow-x: auto;
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa; /* Efeito hover suave */
    }
    .list-group-item {
        font-size: 0.95rem;
        padding: 8px;
    }
    .short-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        max-width: 200px;
    }
    .full-text {
        display: block;
        white-space: normal;
        word-break: break-word;
        max-width: 200px;
    }
</style>

{{-- Script para alternar o texto completo --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.toggle-text').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                let parent = this.parentElement;
                parent.querySelector('.short-text').classList.toggle('d-none');
                parent.querySelector('.full-text').classList.toggle('d-none');
                this.textContent = this.textContent === "Ver mais..." ? "Ver menos..." : "Ver mais...";
            });
        });
    });
</script>

@endsection
