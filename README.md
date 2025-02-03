# Flint-framework 

Flint é um micro-framework PHP elegante e poderoso, projetado para criar aplicações robustas com facilidade.

## Características

- Roteamento simples e intuitivo com suportes a parâmetros dinâmicos
- Suporte a middlewares
- Manipulação de requisições e respostas HTTP

## Requisitos

- PHP 7.4 ou superior
- Composer

## Instalação

1. Clone o repositório usando o comando a baixo:

   ```bash
   git clone https://github.com/claudiovictors/flint.git
   ```

2. Crie um projecto usando composer

    ```bash
    composer create-project flintphp/flintphp flint-app
    ```

## Funcionalidades

#### 1 - Rotas
Gerenciamento de rotas `GET`, `POST`, `PATH`, `PUT`, `DELETE`, `OPTIONS`. Suporte a parâmetros dinâmicos, como IDs, e nomes nas URLs. Fácil integração com controladores e ações.

#### 2 - ORM (Object-Relational Mapping)

- `save()`: Inserir dados no banco de dados.

- `All()`: Recuperar todos os registros.

## Estrutura do Flint

O flint tem uma estrura padrão. para começar a usar o flint usa-se o método `Create()` para iniciar aplicação e o método `run()` para a executar aplicação. Aqui está um exemplo prático.

```php
use Flint\Core\App;

$app = App::create(); // Iniciar o flint

$app->getRoute()->get('/', function($request, $response){
    $response->send('Hello, World!');
});

$app->run(); // Executando o flint
```

## Rotas com funções anonimas

No Flint, definir rotas é muito simples. Você pode usar métodos como `get()`, `post()`, e outros para criar rotas que respondem a diferentes tipos de requisições HTTP:

```php
$router->get('/hello/{name}', function($req, $res){
    $res->send('Hello, '. $req->param('name'));
});
```

## Rotas com controladores

O flint suporta a rotas com controladores

```php
use Flint\App\HomeController;

$router->get('/', [HomeController::class, 'index']);
