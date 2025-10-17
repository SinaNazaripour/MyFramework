<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array  $routes = [];
    private array $middlewares = [];

    public function add(string $method = "GET", string $path, array $controller)
    {
        $this->routes[] = [
            'path' => $this->normalizePath($path),
            'method' => strtoupper($method),
            'controller' => $controller
        ];
    }

    private function normalizePath(string $path)
    {
        // if ($path === "/") {
        //     return $path;
        // };

        $path = trim($path, "/");
        $path = preg_replace("#[/]{2,}#", "/", $path);
        return "/{$path}/";
    }

    public function dispatch(string $path, string $method = "GET", Container|null $container = null)
    {
        $path = $this->normalizePath($path);
        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            if (!preg_match("#^{$route['path']}$#", $path) || ($method !== $route['method'])) {
                continue;
            }
            [$class, $function] = $route['controller'];

            $controlerInstance = $container ? $container->resolve($class) : new $class;
            $action = fn() => $controlerInstance->{$function}();

            foreach ($this->middlewares as $middleware) {
                $middlewareInstance = $container ? $container->resolve($middleware) : new $middleware;
                $middlewareInstance->process($action);
                return;
            }
        }
    }
    public function addMiddleware(string $middleware)
    {
        $this->middlewares[] = $middleware;
    }
}
