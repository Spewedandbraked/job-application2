<?php

namespace App\Core;

class Router
{
    protected $routes = [];
    protected $params = [];

    public function add($route, $controller, $action, $method = 'GET')
    {
        $this->routes[] = [
            'route' => $route,
            'controller' => $controller,
            'action' => $action,
            'method' => $method
        ];
    }

    public function dispatch($uri)
    {
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            // todo: почитать, что такое "регулярки" в роутере
            if ($route['route'] === $uri && $route['method'] === $method) {
                $controllerClass = $route['controller'];
                $action = $route['action'];

                if (class_exists($controllerClass)) {
                    $controller = new $controllerClass();
                    if (method_exists($controller, $action)) {
                        return $controller->$action();
                    }
                }
            }
        }

        // 404
        $this->notFound();
    }

    protected function notFound()
    {
        http_response_code(404);
        echo "404 - Page not found";
        exit;
    }
}
