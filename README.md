# 🎯 Sistema de Gamificação com Perguntas 🏀  

Este projeto é um sistema de gamificação baseado em perguntas e desafios, com foco no basquete PRJ (Projeto voluntário da comunidade). 
O sistema apresenta aos usuários uma série de perguntas com pontuação associada, aplica penalidades caso o tempo para responder expire e mantém um ranking dos melhores jogadores. Uma área administrativa exclusiva permite que apenas usuários administradores gerenciem as questões e gerem relatórios detalhados.

---

# Sumário
* Tecnologias Utilizadas
* Funcionalidades
* Arquitetura
* Requisitos
* Instalação e Configuração
* Uso
    * Fluxo do Usuário
    * Área Administrativa
* Rotas Principais
* Estrutura do Projeto
* Tecnologias
* License

---

## 🚀 Tecnologias Utilizadas

- **Laravel 11** - Framework PHP  
- **MySQL** - Banco de dados relacional  
- **Bootstrap 5** - Estilização do front-end  
- **Blade** - Motor de templates do Laravel  
- **TailwindCSS** - Estilos adicionais  
- **Tinker** - Para testes no banco de dados  
- **Migrations e Seeders** - Gerenciamento do banco  
- **Docker** - Ambiente de desenvolvimento

---
## 📌 Funcionalidades Principais

✔️ **Autenticação e Sessões:**

    Login automático por email e nome.
    Armazenamento do ID do usuário na sessão para controle de acesso.

✔️ **Módulo de Jogo:**

    Exibição de perguntas com um timer de 30 segundos.
    Aplicação de penalidade de -6 pontos se o tempo para responder expirar.
    Atualização da pontuação do usuário conforme respostas corretas/erradas.
    Registros de penalidades na tabela penalties, associando a pergunta e os pontos perdidos.
        
✔️ **Ranking e Relatórios:**

    Ranking dos melhores jogadores (excluindo administradores).
    Relatório administrativo que exibe:
    Nome do usuário
    Pontuação atual
    Lista de perguntas respondidas (com perguntas, respostas e indicação se estava correta ou errada)
    Penalidades aplicadas (com o ID da pergunta e os pontos perdidos)

✔️ **Área Administrativa:**

    Gerenciamento de perguntas (CRUD: criar, editar, excluir).
    Geração de relatórios detalhados (acessível somente para usuários administradores via middleware).

✔️ **Controle de Acesso:**

    Uso de um middleware personalizado (AdminMiddleware)
    que garante que somente usuários com is_admin verdadeiro possam acessar as rotas administrativas.

---

## 📌 Arquitetura

O projeto segue o padrão MVC (Model–View–Controller) com camadas adicionais para manter o código limpo e organizado:

1️⃣ **Controllers:** Responsáveis por orquestrar as requisições HTTP, delegando a lógica de negócio aos Services.

2️⃣ **Services:** Contêm a lógica de negócio (como avaliar respostas, aplicar penalidades, gerar relatórios) e interagem com os Repositories.

3️⃣ **Repositories:** Encapsulam o acesso aos dados (por exemplo, buscar perguntas não respondidas, obter ranking de usuários).

4️⃣ **Models:** Representam as tabelas do banco de dados, como User, Question, Answer e Penalty.

5️⃣ **Middleware:** Um middleware personalizado (AdminMiddleware) que protege as rotas administrativas.

6️⃣ **Testes:** Testes unitários para os Services e Controllers, garantindo que a lógica de negócio e as requisições HTTP funcionem conforme esperado.

---
## 📌 Requisitos

* PHP 8.x
* Laravel 11
* MySQL ou outro banco de dados suportado
* Composer
* NPM (para gerenciamento de assets)
* Docker (opcional)
* Frontend: Bootstrap 5, HTML, CSS, JavaScript
  
---
## 🛠️ Instalação e Configuração

1️⃣ Clonar o repositório:
```bash
    git clone https://github.com/sandoelio/gamificacao.git
    cd gamificacao
```

2️⃣ Instalar as dependências:
```
    composer install
    npm install
```

3️⃣ Configurar o ambiente:
```
    cp .env.example .env
```

4️⃣ Gere a chave da aplicação:
```
    php artisan key:generate
```

⚠️ Importante: Configure o .env com as credenciais do banco de dados.


5️⃣ Criar o banco de dados e rodar as migrations:
```
    php artisan migrate
```

6️⃣ Importante: Rode as seeders
```
    php artisan db:seed
```

7️⃣ Verificar o usuário administrador no banco:

📌 Rodar o servidor local:
```
    php artisan serve
```
## Ou utilizando o Docker:

* Criar o arquivo .env com as configurações do banco de dados
```
cp .env.example .env
```

⚠️ Importante: Configure o .env com as credenciais do banco de dados e não esqueça de usar o DB_HOST dessa maneira.

```
DB_HOST=mysql
```

* Rodar o comando:
```
docker-compose up -d
```

* Acesse o container:
```
docker exec -it gamificacao_app_1 bash
```

* Gere a chave da aplicação:
```
php artisan key:generate
```

* Rode as migrations:
```
php artisan migrate
```

* Rode as seeders
```
php artisan db:seed
```

* Verificar o usuário administrador no banco:

---

🎮 Como Funciona?

**Login:**

    O usuário acessa a tela de login e entra com seu nome e email. O ID do usuário é armazenado na sessão.

**Jogo:**
    
    Após o login, o usuário é apresentado a uma pergunta com um timer de 30 segundos. 
    Se o tempo expirar, uma penalidade de -6 pontos é aplicada e um registro é criado na tabela penalties, 
    associando a pergunta e os pontos perdidos.Respostas corretas somam os pontos da pergunta; respostas erradas podem ter outras lógicas definidas.

**Ranking:**

    O dashboard exibe a pontuação atual do usuário e o ranking dos melhores jogadores (excluindo administradores).

**Área Administrativa:**

    Apenas usuários administradores podem acessar as rotas de gerenciamento de perguntas (CRUD). 
    Essas rotas são protegidas pelo middleware AdminMiddleware.

**Relatórios:** 

    A área administrativa inclui um relatório que exibe para cada usuário:
    Nome do usuário
    Pontuação atual
    Perguntas respondidas (pergunta, resposta, se estava correta)
    Penalidades aplicadas (com ID da pergunta e pontos perdidos)

---

📝 Licença
Este projeto está licenciado sob a MIT License.
Sinta-se livre para contribuir e aprimorar o sistema! 🚀
