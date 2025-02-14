<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Perguntas')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body {
        background-color: #f8f9fa;
      }
      /* Container centralizado com max-width e margens */
      .main-container {
        max-width: 900px;
        margin: 50px auto 20px auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
      }
      /* Estilização da navbar para que fique dentro do container */
      .custom-navbar {
        background-color: #343a40;
        padding: 10px;
        border-radius: 5px;
        display: flex;
        justify-content: center; /* Centraliza o conteúdo */   
      }
      .custom-navbar .navbar-brand {
        color: #fff;
        font-size: 1.5rem;
        font-weight: bold;
        display: flex;
        flex-direction: column; /* Coloca a imagem acima do texto */
        align-items: center; /* Centraliza horizontalmente */
        text-align: center; /* Centraliza o texto */
      }
      /* Ajustes para botões de ação na listagem */
      .action-buttons {
        display: flex;
        gap: 50px;
      }
      .img-thumbnail1 {    
        max-width:150px; 
        height:auto;
        display: block;
      }

    </style>
  </head>
  <body>
    <nav class="navbar navbar-dark custom-navbar">
      <div class="container d-flex flex-column align-items-center">
        <a class="navbar-brand" href="{{ route('game.dashboard') }}">
          <img src="{{ asset('imagens/slogan2.png') }}" alt="Imagem" class="img-thumbnail1">
           Gamificação com Perguntas
        </a>
      </div>
    </nav>
    
    <div class="container main-container">
      @yield('content')
    </div>

  </body>
</html>
