@extends('layouts.app')

@section('title', 'Tempo Esgotado')

@section('content')
<div class="container text-center mt-4">
    <div class="alert alert-warning">
        <h2>Tempo Esgotado!</h2>
        <p>Seu tempo para responder essa pergunta acabou.</p>
        <p>Uma penalidade de <strong>-6 pontos</strong> foi aplicada.</p>
        <p>Sua pontuação atual: <strong>{{ $currentScore }}</strong> pontos.</p>
        <p>Retorne e termine de responder as perguntas</p>
    </div>
    <a href="{{ route('game.index') }}" class="btn btn-primary">Continuar</a>
</div>
@endsection
