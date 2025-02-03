# Flint

Flint é um micro-framework PHP elegante e poderoso, projetado para criar aplicações robustas com facilidade. Com suporte nativo a rotas dinâmicas, middlewares flexíveis e APIs RESTful, o Flint oferece as ferramentas essenciais para desenvolvedores que buscam produtividade e performance sem complicações.

## Características

- Roteamento simples e intuitivo com suporte a parâmetros dinâmicos
- Suporte a `middlewares`
- Manipulação de requisições e respostas HTTP
- Suporte à autenticação `JWT`
- Funções auxiliares (`Helpers`)
- Conexão com diferentes tipos de bancos de dados, com suporte nativo ao `MySQL`

## Requisitos

- PHP 7.4 ou superior
- Composer

## Instalação

1. Clone o repositório usando o comando abaixo:

   ```bash
   git clone https://github.com/claudiovictors/flint.git
   ```

2. Crie um projeto usando o Composer:

   ```bash
   composer create-project flintphp/flintphp [app_name]
   ```
3. Inicie o servidor embutido do PHP:

    ```bash
    php -S localhost:3000 -t public
    ```

## Estrutura de Pastas

O Flint segue uma estrutura simples baseada no padrão `MVC`:

```bash
flint/
    app/
        Controllers/  # Arquivos de controladores
        Models/       # Modelos de dados (ex: UserModel)
        Views/        # Arquivos de Views (templates)
    src/
        Core/        # Arquivos de configuração do Flint
        Databases/   # Configuração do banco de dados
        Errors/      # Arquivos e templates de erro
        Https/       # Manipulação de requisições HTTP
        Library/     # Bibliotecas do Flint (ex: Emails, ORM, etc.)
        Middlewares/ # Middlewares personalizados
        Util/        # Funções auxiliares (`Helpers`)
    vendor/
```

## Estrutura do Flint

O Flint possui uma estrutura padrão para inicializar e executar a aplicação. Para iniciar, utilize o método `create()` e, em seguida, `run()` para executá-la. Exemplo:

```php
use Flint\Core\App;

$app = App::create(); // Iniciar o Flint

// Lógica da aplicação

$app->run(); // Executar o Flint
```

## Definição de Rotas

No Flint, definir rotas é muito simples. Você pode utilizar métodos como `get()`, `post()`, `put()`, `delete()`, entre outros, para criar rotas que respondem a diferentes tipos de requisições HTTP.

### Rotas com Funções Anônimas

```php
use Flint\Core\App;

$app = App::create();

// Rota GET
$app->get('/', function($req, $res) {
    $res->send('Hello, World!');
});

// Rota POST
$app->post('/submit', function($req, $res) {
    $res->send('Data submitted successfully!');
});

// Rota PUT
$app->put('/update', function($req, $res) {
    $res->send('User updated!');
});

// Rota DELETE
$app->delete('/delete', function($req, $res) {
    $res->send('User deleted!');
});

// Rota OPTIONS
$app->options('/info', function($req, $res) {
    $res->send('Available methods: GET, POST, DELETE, etc.');
});

$app->run();
```

### Rotas com Controladores

O Flint suporta a definição de rotas utilizando controladores no formato de `array()`, onde `[Classe, Método]` representa a classe do controlador e o método que será executado.

```php
use Flint\Core\App;
use App\Controllers\HomeController;

$app = App::create();

$app->get('/', [HomeController::class, 'index']);

$app->run();
```

#### Criando o HomeController

Crie um arquivo `HomeController.php` no diretório `app/Controllers/`:

```php
namespace App\Controllers;

class HomeController {
    public function index($req, $res) {
        $res->send('Welcome to HomeController!');
    }
}
```

### Rotas com Parâmetros Dinâmicos

O Flint permite a criação de rotas com parâmetros dinâmicos para capturar IDs nas URLs. Para isso, utilize `{param}` dentro do caminho da rota.

```php
use Flint\Core\App;

$router->get('/', [HomeController::class, 'index']);
```

## Configuração do Banco de Dados

O Flint permite a configuração de conexões com diferentes bancos de dados. Para configurar o MySQL, edite o arquivo `.env`:

```bash
#Configuração de E-mail (SMTP)
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seuemail@gmail.com
MAIL_PASSWORD=sua_senha
MAIL_ENCRYPTION=tls
```

## Middlewares

Os middlewares permitem manipular requisições antes de serem processadas pelos controladores. Exemplo de middleware:

```php
namespace App\Middlewares;

class AuthMiddleware {
    public function handle($req, $res, $next) {
        if (!$req->header('Authorization')) {
            return $res->status(401)->send('Unauthorized');
        }
        return $next($req, $res);
    }
}
```

## Conclusão

O Flint é um micro-framework poderoso, flexível e fácil de usar, permitindo que desenvolvedores criem aplicações escaláveis e bem estruturadas. Seja para desenvolvimento de APIs ou aplicações web completas, o Flint oferece uma base sólida para começar.

Agradecemos por escolher o Flint! Se tiver dúvidas, sugestões ou quiser contribuir, visite o repositório no <a name='https://github.com/claudiovictors/flint.git'>GitHub</a>. Feliz codificação! 🚀