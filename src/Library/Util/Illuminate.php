<?php

declare(strict_types=1);

/**
 * Arquivo de configuração de banco de dados Flint.
 *
 * Este arquivo é responsável retornar os tipos de conexão de banco de dados
 */

function loadEnv(string $filePath): void {

    if(!file_exists($filePath)):
        throw new Exception('.env file not found!');
    endif;

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach($lines as $line):
        if(str_starts_with(trim($line), '#')):
            continue;
        endif;

        list($key, $value) = explode('=', $line, 2);

        $key = trim($key);
        $value = trim($value, "\"' ");

        putenv("$key=$value");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    endforeach;
}