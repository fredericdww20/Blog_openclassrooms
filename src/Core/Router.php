<?php

namespace App\Core;

class Router {
    private array $routes = [];

    public static function redirect($path): void
    {
        header('Location: ' . $path);
        exit();
    }

    public function addRoute($method, $path, $callback): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback
        ];
    }

    public function dispatch(): void
    {
        $requestedUrl = $_SERVER['REQUEST_URI'];
        $requestedMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestedMethod && preg_match($route['path'], $requestedUrl, $matches)) {
                array_shift($matches);
                $response = call_user_func_array($route['callback'], $matches);
                if ($response instanceof Response) {
                    $response->send();
                }
                return;
            }
        }

        // No route matched; handle 404
        $response = new Response("404 Not Found", 404);
        $response->send();
    }
}