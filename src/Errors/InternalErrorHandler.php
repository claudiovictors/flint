<?php

declare(strict_types=1);

namespace Flint\Errors;

use Flint\Https\Request;
use Flint\Https\Response;

class InternalErrorHandler {
    public function handle(Request $resquest, Response $response, \Throwable $exception): void {
        $response->setStatusCode(500);
        $template = file_get_contents(__DIR__.'/Templates/500.html');
        $response->send($template);
    }
}