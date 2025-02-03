<?php

declare(strict_types=1);

namespace Flint\Middlewares;

use Flint\Https\Request;
use Flint\Https\Response;

class Middleware {

    private array $middlewares = [];
    private int $index = 0;

    public function addMiddleware($middlewares): void {
        $this->middlewares = $middlewares;
    }

    public function handle(Request $request, Response $response): mixed {

        if($this->index > count($this->middlewares)):
            $middleware = $this->middlewares[$this->index];
            return $middleware->process($request, $response, [$this, 'handle']);
        endif;

        return $response;
    }
}