<?php

namespace App\Core;

use App\Controllers\HomeController;
use App\Core\Router;

class App
{
    protected $router;

    public function __construct()
    {
        $this->router = new Router();
        $this->loadRoutes();
    }

    protected function loadRoutes()
    {
        $this->router->add('/', HomeController::class, 'index', 'GET');
    }

    public function run()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $uri = rtrim($uri, '/');
        $uri = $uri ?: '/';

        $this->router->dispatch($uri);
    }
}
