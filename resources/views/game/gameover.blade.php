@extends('layouts.app')

@section('title', 'Game Over')

@section('content')
<div class="container text-center mt-4">
    <h1>Game Over</h1>
    <p>Você respondeu 15 perguntas!</p>
    <p>Sua pontuação final: <strong>{{ $currentScore }}</strong> pontos.</p>
    <a href="{{ route('game.dashboard') }}" class="btn btn-primary">Dashboard</a>
</div>
@endsection
