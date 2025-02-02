<?php

declare(strict_types=1);

/**
 * Arquivo principal de inicialização e configuração do Flint.
 *
 * Este arquivo é responsável por criar a instância da aplicação, definir as rotas
 * e executar o framework.
 */

namespace Flint\Databases;

use PDO;

class ModelPdo {

    private static mixed $instance = null;
    private static object $modelpdo;

    private function __construct()
    {
        $config = require_once __DIR__ . '/../Core/Database.php';

        self::$modelpdo = new PDO($config['pdo']['dsn'],$config['pdo']['username'],$config['pdo']['password']);
        self::$modelpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$modelpdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }

    public static function getInstance(){
        if(self::$instance === null):
            self::$instance = new ModelPdo();
        endif;

        return self::$modelpdo;
    }
}