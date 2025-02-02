<?php

declare(strict_types=1);

namespace Flint\Core;

use Flint\Https\Router;

/**
 * Classe principal que representa a aplicação Flint.
 *
 * Esta classe é responsável por inicializar o roteador e executar a aplicação.
 */
class App {

    /**
     * Instância do roteador.
     *
     * @var Router
     */
    private Router $router;

    /**
     * Construtor da classe App.
     *
     * Inicializa o roteador.
     */
    public function __construct(){
        $this->router = new Router();
    }

    /**
     * Método estático para criar uma nova instância da aplicação.
     *
     * @return self Uma nova instância da classe App.
     */
    public static function create(): self {
        return new self();
    }

    /**
     * Retorna a instância do roteador.
     *
     * @return Router A instância do roteador.
     */
    public function getRoute(): Router {
        return $this->router;
    }

    /**
     * Executa a aplicação.
     *
     * Este método despacha a requisição para o roteador.
     *
     * @return void
     */
    public function run(): void {

        try {
            $this->router->dispatch();
        }catch(\Exception $error){
            die("Error: ". $error->getMessage());
        }
    }
}