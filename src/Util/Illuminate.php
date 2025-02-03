<?php

function view(string $template, array $data = []): void {
        
    $directory = __DIR__ . '/../../app/Views'. $template .'.html';
        $pageError = __DIR__ . '/../Errors/Templates/404.html';
        
        if(!file_exists($directory)):
            require_once $pageError;
        endif;

        $contentTemplate = file_get_contents($directory);

        $keyVariable = array_keys($data);
        $keyVariable = array_map(function($items){
            return "{{{$items}}}";
        }, $keyVariable);

    echo str_replace($keyVariable, array_values($data), $contentTemplate);
}
