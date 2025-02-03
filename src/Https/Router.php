<?php

declare(strict_types=1);

/**
 * Classe responsável por gerenciar e despachar as rotas HTTP.
 */

namespace Flint\Https;

class Router {

    /**
     * Array que armazena as rotas HTTP.
     *
     * @var array<int, array<string, mixed>>
     */
    private array $routers = [];

    /**
     * Adiciona uma nova rota.
     *
     * @param string $method O método HTTP da rota (GET, POST, PUT, DELETE, etc.).
     * @param string $routePath O caminho da rota.
     * @param callable|array $handles A função ou array que trata a requisição. Pode ser um callable ou um array contendo [Classe::class, 'metodo'].
     * @param callable|array $middlewares Middlewares a serem executados antes do handler.
     * @return void
     */
    public function addRoute(string $method, string $routePath, callable|array $handles, callable|array $middlewares = []): void {
        $this->routers[] = [
            'method' => strtoupper($method),
            'routePath' => $routePath,
            'handles'   => $handles,
            'middleware' => $middlewares
        ];
    }

    /**
     * Adiciona uma rota GET.
     *
     * @param string $routePath O caminho da rota.
     * @param callable|array $handles A função ou array que trata a requisição.
     * @param callable|array $middlewares Middlewares a serem executados antes do handler.
     * @return void
     */
    public function get(string $routePath, callable|array $handles, callable|array $middlewares = []): void {
        $this->addRoute('GET', $routePath, $handles, $middlewares);
    }

    /**
     * Adiciona uma rota POST.
     *
     * @param string $routePath O caminho da rota.
     * @param callable|array $handles A função ou array que trata a requisição.
     * @param callable|array $middlewares Middlewares a serem executados antes do handler.
     * @return void
     */
    public function post(string $routePath, callable|array $handles, callable|array $middlewares = []): void {
        $this->addRoute('POST', $routePath, $handles, $middlewares);
    }

    /**
     * Adiciona uma rota PUT.
     *
     * @param string $routePath O caminho da rota.
     * @param callable|array $handles A função ou array que trata a requisição.
     * @param callable|array $middlewares Middlewares a serem executados antes do handler.
     * @return void
     */
    public function put(string $routePath, callable|array $handles, callable|array $middlewares = []): void {
        $this->addRoute('PUT', $routePath, $handles, $middlewares);
    }

    /**
     * Adiciona uma rota PATCH.
     *
     * @param string $routePath O caminho da rota.
     * @param callable|array $handles A função ou array que trata a requisição.
     * @param callable|array $middlewares Middlewares a serem executados antes do handler.
     * @return void
     */
    public function patch(string $routePath, callable|array $handles, callable|array $middlewares = []): void { // Corrigido o nome do método para patch
        $this->addRoute('PATCH', $routePath, $handles, $middlewares);
    }

    /**
     * Adiciona uma rota DELETE.
     *
     * @param string $routePath O caminho da rota.
     * @param callable|array $handles A função ou array que trata a requisição.
     * @param callable|array $middlewares Middlewares a serem executados antes do handler.
     * @return void
     */
    public function delete(string $routePath, callable|array $handles, callable|array $middlewares = []): void {
        $this->addRoute('DELETE', $routePath, $handles, $middlewares);
    }

    /**
     * Adiciona uma rota OPTIONS.
     *
     * @param string $routePath O caminho da rota.
     * @param callable|array $handles A função ou array que trata a requisição.
     * @param callable|array $middlewares Middlewares a serem executados antes do handler.
     * @return void
     */
    public function options(string $routePath, callable|array $handles, callable|array $middlewares = []): void {
        $this->addRoute('OPTIONS', $routePath, $handles, $middlewares);
    }

    /**
     * Despacha a requisição para a rota correspondente.
     *
     * @return void
     */
    public function dispatch(): void {

        $response = new Response();
        $request = new Request();

        $methodType = $request->getMethodType();
        $routePathUri = $request->getRoutePath();

        foreach($this->routers as $routes):

            $patterns = preg_replace('/{([a-zA-Z0-9_]+)}/', '(?P<$1>[a-zA-Z0-9_-]+)', $routes['routePath']);

            if($routes['method'] === $methodType && preg_match('#^'. $patterns .'$#', $routePathUri, $matches)):

                $paramKey = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                foreach($routes['middleware'] as $middleware):
                    if(is_callable($middleware)):
                        $middlewareResponse = $middleware($request, $response);

                        if($middlewareResponse instanceof Response):
                            $middlewareResponse->send();
                            return;
                        endif;
                    endif;
                endforeach;

                if (is_callable($routes['handles'])) {
                    call_user_func($routes['handles'], new Request($paramKey), $response); // Passa $response para o handler
                    return;
                } elseif (is_array($routes['handles']) && count($routes['handles']) === 2) { // Verifica se é um array com 2 elementos (Classe e Método)
                    [$className, $methodName] = $routes['handles'];
                    if (class_exists($className) && method_exists($className, $methodName)) { // Verifica se a classe e o método existem
                        call_user_func([new $className, $methodName], new Request($paramKey), $response); // Passa $response para o handler
                        return;
                    } else {
                         $response->status(500)->send("Internal Server Error: Class or method not found.");
                        return;
                    }
                }

            endif;
        endforeach;

        $response->status(404)->send("Not Found");
        return;
    }
}