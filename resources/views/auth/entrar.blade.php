<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background: linear-gradient(to right, #1e3c72, #2a5298);
                color: white;
            }
            .container {
                background: rgba(255, 255, 255, 0.1);
                padding: 30px;
                border-radius: 10px;
                text-align: center;
                width: 100%;
                max-width: 400px;
                display: flex;
                flex-direction: column; /* Coloca a imagem acima do texto */
                align-items: center; /* Centraliza horizontalmente */
                text-align: center; /* Centraliza o texto */             
            }
            input {
                width: 100%;
                padding: 10px;
                margin: 10px -6px;
                border: none;
                border-radius: 5px;
            }
            button {
                background: #ffcc00;
                color: black;
                padding: 10px 20px;
                margin: 0% -2%;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                width: 106%;
            }
            .img-thumbnail1 {    
                max-width:150px; 
                height:auto;
                display: block;
                display: flex;
                margin-bottom: -20px;
            }
        </style>
    </head>
    <body>

        <div class="container">
            <img src="{{ asset('imagens/slogan.png') }}" alt="Imagem" class="img-thumbnail1">
            <h3>Seja bem-vindo(a)!</h3>
            @if (session('error'))
                <div class="text-red-500 text-sm mb-4">
                    {{ session('error') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="name" name="name" placeholder="Digite seu nome" required>
                <input type="email" name="email" placeholder="Digite seu e-mail" required>
                <button type="submit">Entrar</button>
            </form>

        </div>

    </body>
</html>

