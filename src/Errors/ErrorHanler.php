<?php

declare(strict_types=1);

namespace Flint\Errors;

class ErrorHandler {

    private bool $debug;

    public function __construct(bool $debug = false)
    {
        $this->debug = $debug;
    }

    public function register(): void {
        set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);
    }

    public function handleError(int $errno, string $errstr, string $errfile, int $errline): void {
        $this->renderErrorPage(500, "Error: $errstr in $errfile on line $errline");
    }

    public function handleException(\Throwable $exception): void {
        $this->renderErrorPage(
            500,
            $this->debug
                ? $exception->getMessage(). "<br/>File: {$exception->getFile()}<br>Line: {$exception->getLine()}"
                : "An internal error ocurred."
        );
    }


    private function renderErrorPage(int $statusCode, string $message): void {
        http_response_code($statusCode);
        echo $this->generateHtml($statusCode, $message);
        exit;
    }

    private function generateHtml(int $statusCode, string $message): string {
        return "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Error {$statusCode}</title>
            </head>
            <body>
                <h1>Error {$statusCode}</h1>
                <p>{$message}</p>
            </body>
            </html>
        ";
    }
}