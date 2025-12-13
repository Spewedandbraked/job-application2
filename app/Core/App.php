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
        $this->router->add('/second-task', \App\Controllers\SecondTask::class, 'querry', 'GET');
        $this->router->add('/second-task2', \App\Controllers\SecondTask::class, 'querryBuilder', 'GET');
    }

    public function handle(Request $request)
    {
        return $this->router->dispatch($request);
    }
}