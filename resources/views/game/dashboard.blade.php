@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Parte 1: Perfil do Usuário e Regras -->
        <div class="col-md-6">
            <div class="card shadow-lg p-4">
                <h2 class="text-center">Bem-vindo, {{ $user->name }}!</h2>
                <hr>
                <h4>📜 Regras do Jogo</h4>
                <ul class="list-group">
                    <li class="list-group-item">🔹 Responda até 15 perguntas.</li>
                    <li class="list-group-item">✅ Acertos aumentam sua pontuação.</li>
                    <li class="list-group-item">❌ Erros reduzem 50% do valor da questão.</li>
                    <li class="list-group-item">⏳ O tempo limite para cada pergunta é de 30 segundos.</li>
                </ul>
                <div class="text-center mt-4">
                    <a href="{{ route('game.index') }}" class="btn btn-success btn-lg">🎮 Jogar Agora</a>
                    <a href="{{ route('logout') }}" class="btn btn-danger btn-lg"> Sair</a>
                </div>
            </div>
        </div>

        <!-- Parte 2: Ranking dos 10 Melhores -->
        <div class="col-md-6">
            <div class="card shadow-lg p-4">
                <h2 class="text-center">🏆 Ranking dos Top 10</h2>
                <hr>
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Jogador</th>
                            <th>Pontos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ranking as $index => $player)
                        <tr>
                            <td><strong>{{ $index + 1 }}</strong></td>
                            <td>{{ $player->name }}</td>
                            <td>{{ $player->points }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
