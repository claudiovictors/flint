<?php

declare(strict_types=1);

namespace Flint\Errors;

use Flint\Https\Request;
use Flint\Https\Response;

class NotFoundHandler {

    public function handle(Request $resquest, Response $response, \Throwable $exception): void {
        $response->setStatusCode(404);
        $template = file_get_contents(__DIR__.'/Templates/404.html');
        $response->send($template);
    }
}