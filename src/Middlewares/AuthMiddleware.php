<?php

declare(strict_types=1);

namespace Flint\Middlewares;

use Flint\Https\Request;
use Flint\Https\Response;

class AuthMiddleware {

    public function process(Request $request, Response $response, callable $next): mixed {

        if(!$request->getHeader('Authorization')):
            $response->setStatusCode(401);
            $response->send('Unauthorized');
            return $response;
        endif;

        return $next($request, $response);
    }
}