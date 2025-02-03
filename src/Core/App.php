<?php

declare(strict_types=1);

namespace Flint\Core;

use Flint\Errors\InternalErrorHandler;
use Flint\Errors\NotFoundHandler;
use Flint\Https\Request;
use Flint\Https\Response;
use Flint\Https\Router;
use Flint\Middlewares\Middleware;
use Throwable;

/**
 * Classe principal que representa a aplicação Flint.
 * 
 * Responsável por inicializar o roteador, gerenciar middlewares e tratar erros.
 */
class App
{
    /**
     * Instância do roteador.
     *
     * @var Router
     */
    private Router $router;

    /**
     * Instância do middleware manager.
     *
     * @var Middleware
     */
    private Middleware $middlewares;

    /**
     * Lista de manipuladores de erro.
     *
     * @var array<int, object>
     */
    private array $errorHandler;

    /**
     * Construtor da classe App.
     *
     * Inicializa o roteador, middlewares e handlers de erro.
     */
    public function __construct()
    {
        $this->router = new Router();
        $this->middlewares = new Middleware();
        $this->errorHandler = [
            400 => new NotFoundHandler(),
            500 => new InternalErrorHandler(),
        ];
    }

    /**
     * Método estático para criar uma nova instância da aplicação.
     *
     * @return self Uma nova instância da classe App.
     */
    public static function create(): self
    {
        return new self();
    }

    /**
     * Registra uma rota GET na aplicação.
     *
     * @param string $routePath Caminho da rota.
     * @param callable|array $handles Controladores da rota.
     * @param callable|array $middlewares Middlewares aplicáveis à rota.
     */
    public function get(string $routePath, callable|array $handles, callable|array $middlewares = []): void
    {
        $this->router->addRoute('GET', $routePath, $handles, $middlewares);
    }

    /**
     * Registra uma rota POST na aplicação.
     *
     * @param string $routePath Caminho da rota.
     * @param callable|array $handles Controladores da rota.
     * @param callable|array $middlewares Middlewares aplicáveis à rota.
     */
    public function post(string $routePath, callable|array $handles, callable|array $middlewares = []): void
    {
        $this->router->addRoute('POST', $routePath, $handles, $middlewares);
    }

    /**
     * Registra uma rota PUT na aplicação.
     *
     * @param string $routePath Caminho da rota.
     * @param callable|array $handles Controladores da rota.
     * @param callable|array $middlewares Middlewares aplicáveis à rota.
     */
    public function put(string $routePath, callable|array $handles, callable|array $middlewares = []): void
    {
        $this->router->addRoute('PUT', $routePath, $handles, $middlewares);
    }

    /**
     * Registra uma rota PATCH na aplicação.
     *
     * @param string $routePath Caminho da rota.
     * @param callable|array $handles Controladores da rota.
     * @param callable|array $middlewares Middlewares aplicáveis à rota.
     */
    public function patch(string $routePath, callable|array $handles, callable|array $middlewares = []): void
    {
        $this->router->addRoute('PATCH', $routePath, $handles, $middlewares);
    }

    /**
     * Registra uma rota DELETE na aplicação.
     *
     * @param string $routePath Caminho da rota.
     * @param callable|array $handles Controladores da rota.
     * @param callable|array $middlewares Middlewares aplicáveis à rota.
     */
    public function delete(string $routePath, callable|array $handles, callable|array $middlewares = []): void
    {
        $this->router->addRoute('DELETE', $routePath, $handles, $middlewares);
    }

    /**
     * Registra uma rota OPTIONS na aplicação.
     *
     * @param string $routePath Caminho da rota.
     * @param callable|array $handles Controladores da rota.
     * @param callable|array $middlewares Middlewares aplicáveis à rota.
     */
    public function options(string $routePath, callable|array $handles, callable|array $middlewares = []): void
    {
        $this->router->addRoute('OPTIONS', $routePath, $handles, $middlewares);
    }

    /**
     * Executa a aplicação.
     *
     * Captura a requisição, executa middlewares e trata erros caso ocorram.
     */
    public function run(): void
    {
        try {
            $request = new Request();
            $response = new Response();

            $this->router->dispatch();
            $response = $this->middlewares->handle($request, $response);

        } catch (Throwable $error) {
            $statusCode = $error->getCode();
            $handler = $this->errorHandler[$statusCode] ?? $this->errorHandler[500];

            $handler->handle(new Request(), new Response(), $error);
        }
    }
}
