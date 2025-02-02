<?php

declare(strict_types=1);

namespace Flint\Https;

/**
 * Classe que representa a resposta HTTP.
 *
 * Esta classe fornece métodos para enviar diferentes tipos de respostas,
 * como JSON, HTML e texto simples, além de definir o código de status.
 */

class Response {

    /**
     * O corpo da resposta.
     *
     * @var string
     */
    private string $body;

    /**
     * O código de status da resposta.
     *
     * @var int
     */
    private int $codeStatus = 200;

    /**
     * Envia uma resposta JSON.
     *
     * @param array<string, mixed> $data Os dados a serem enviados como JSON.
     * @param int $codeStatus O código de status da resposta (padrão: 200).
     * @return void
     */
    public function json(array $data, int $codeStatus = 200): void {
        $this->setStatusCode($codeStatus);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    /**
     * Define o código de status da resposta.
     *
     * @param int $codeStatus O código de status da resposta.
     * @return $this Retorna a instância atual do objeto Response para encadeamento de métodos.
     */
    public function status(int $codeStatus): self { // Alterado para retornar $this
        $this->setStatusCode($codeStatus);
        return $this; // Retorna $this para permitir o encadeamento
    }


    /**
     * Envia uma resposta de texto simples.
     *
     * @param string $content O conteúdo da resposta.
     * @return void
     */
    public function send(string $content = ''): void {
        echo $content;
    }

    /**
     * Define o código de status da resposta.
     *
     * @param int $codeStatus O código de status da resposta.
     * @return void
     */
    public function setStatusCode(int $codeStatus): void {
        $this->codeStatus = $codeStatus;
        http_response_code($this->codeStatus);
    }

    /**
     * Envia uma resposta HTML.
     *
     * @param string $html O conteúdo HTML da resposta.
     * @param int $codeStatus O código de status da resposta (padrão: 200).
     * @return void
     */
    public function html(string $html, int $codeStatus = 200): void {
        http_response_code($codeStatus);
        header('Content-Type: text/html; charset=utf8');
        echo $html;
    }
}