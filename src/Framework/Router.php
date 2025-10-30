<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array  $routes = [];
    private array $middlewares = [];

    public function add(string $method = "GET", string $path, array $controller)
    {
        $regexPath = preg_replace("#{[^/]+}#", "([^/]+)", $path);
        $this->routes[] = [
            'path' => $this->normalizePath($path),
            'method' => strtoupper($method),
            'controller' => $controller,
            'middlewares' => [],
            'regexPath' => $this->normalizePath($regexPath),
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
        $method = $_POST['_METHOD'] ?? strtoupper($method);

        foreach ($this->routes as $route) {
            if (!preg_match("#^{$route['regexPath']}$#", $path, $paramValues) || ($method !== $route['method'])) {
                continue;
            }

            array_shift($paramValues);
            preg_match_all("#{([^/]+)}#", $route['path'], $paramKeys);
            // dd($paramKeys);
            $params = array_combine($paramKeys[1], $paramValues) ?? [];

            [$class, $function] = $route['controller'];

            $controlerInstance = $container ? $container->resolve($class) : new $class;
            $action = fn() => $controlerInstance->{$function}($params);


            $allMiddlewares = [...$route['middlewares'], ...$this->middlewares];
            foreach ($allMiddlewares as $middleware) {
                $middlewareInstance = $container ? $container->resolve($middleware) : new $middleware;
                $action = fn() => $middlewareInstance->process($action);
            }
            $action();
            return;
        }
    }
    public function addMiddleware(string $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function addRouteMiddleware(string $middleware)
    {
        $lastRouteKey = array_key_last($this->routes);
        $this->routes[$lastRouteKey]['middlewares'][] = $middleware;
    }
}
