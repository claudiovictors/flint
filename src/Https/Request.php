<?php

declare(strict_types=1);

namespace Flint\Https;

/**
 * Classe que representa a requisição HTTP.
 *
 * Esta classe fornece métodos para acessar informações da requisição,
 * como parâmetros, método HTTP e caminho da rota.
 */

class Request {

    /**
     * Array contendo os parâmetros da requisição.
     *
     * @var array<string, mixed>
     */
    private array $paramkey = [];

    /**
     * Construtor da classe Request.
     *
     * @param array<string, mixed> $param Array de parâmetros da requisição.
     */
    public function __construct(array $param = []){
        $this->paramkey = $param;
    }

    /**
     * Retorna o valor de um parâmetro da requisição.
     *
     * @param string $key A chave do parâmetro.
     * @return string|null O valor do parâmetro ou null se não existir.
     */
    public function param(string $key): ?string {
        return $this->paramkey[$key] ?? null;
    }

    /**
     * Retorna o método HTTP da requisição.
     *
     * @return string O método HTTP da requisição.
     */
    public function getMethodType(): string {
        return filter_var($_SERVER['REQUEST_METHOD'], FILTER_DEFAULT);
    }

    /**
     * Retorna o caminho da rota da requisição.
     *
     * @return string O caminho da rota da requisição.
     */
    public function getRoutePath(): string {
        return filter_var(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), FILTER_DEFAULT) ?? '/';
    }

    /**
     * Verifica se a requisição está autenticada.
     *
     * Verifica se o cabeçalho 'Authorization' está presente e não está vazio.
     *
     * @return bool True se a requisição estiver autenticada, false caso contrário.
     */
    public function isAuthenticated(): bool {
        $headers = getallheaders();
        return isset($headers['Authorization']) && !empty($headers['Authorization']);
    }

    public function getHeader(): array|false {
        return getallheaders();
    }
}