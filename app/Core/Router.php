<?php

namespace App\Core;

use Symfony\Component\HttpFoundation\Request;

class Router
{
    protected $routes = [];
    
    public function add($route, $controller, $action, $method = 'GET')
    {
        $this->routes[] = [
            'route' => $route,
            'controller' => $controller,
            'action' => $action,
            'method' => $method
        ];
    }

    public function dispatch(Request $request) 
    {
        $uri = $request->getPathInfo(); 
        $method = $request->getMethod(); 

        foreach ($this->routes as $route) {
            if ($route['route'] === $uri && $route['method'] === $method) {
                $controllerClass = $route['controller'];
                $action = $route['action'];

                if (class_exists($controllerClass)) {
                    $controller = new $controllerClass($request);
                    
                    if (method_exists($controller, $action)) {
                        return $controller->$action();
                    }
                }
            }
        }

        $this->notFound();
    }

    protected function notFound()
    {
        http_response_code(404);
        echo "404 - Page not found";
        exit;
    }
}