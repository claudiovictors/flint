<?php

declare(strict_types=1);

namespace Flint\Controllers;

use Flint\Https\Request;
use Flint\Https\Response;

class HomeController {

    public function index($req, $res): void {
        $res->send("Weltome to Flint Home");
    }
}