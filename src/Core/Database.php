<?php

declare(strict_types=1);

/**
 * Arquivo de configuração de banco de dados Flint.
 *
 * Este arquivo é responsável retornar os tipos de conexão de banco de dados
 */

require_once __DIR__ . '/../Library/Util/Illuminate.php';

return [
    'pdo' => [
        'dsn' => 'mysql:host='. getenv('DB_HOST') .';port='. getenv('DB_PORT') .';dbname='. getenv('DB_NAME') .';charset='. getenv('DB_CHAR'),
        'username' => getenv('DB_USER'),
        'password' => getenv('DB_PASS')
    ],

    'mysqli' => [
        'connection' => getenv('DB_HOST').','.getenv('DB_PORT').','.getenv('DB_NAME').','.getenv('DB_USER').','.getenv('DB_PASS')
    ]
];