<?php

namespace App\Core;

use Symfony\Component\HttpFoundation\Request;

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
        $this->router->add('/', \App\Controllers\HomeController::class, 'index', 'GET');
        $this->router->add('/first-task', \App\Controllers\FirstTask::class, 'searchCategory', 'GET');
    }

    public function handle(Request $request)
    {
        return $this->router->dispatch($request);
    }
}