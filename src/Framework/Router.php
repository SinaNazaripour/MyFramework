<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array  $routes = [];

    public function add(string $method = "GET", string $path,array $controller)
    {
        $this->routes[] = [
            'path' => $this->normalizePath($path),
            'method' => strtoupper($method),
            'controller'=>$controller
        ];
    }

    private function normalizePath(string $path)
    {
        // if ($path === "/") {
        //     return $path;
        // };

        $path = trim($path, "/");
        $path=preg_replace("#[/]{2,}#","/",$path);
        return "/{$path}/";

    }

    public function dispatch(string $path,string $method)
    {
        $path=$this->normalizePath($path);
        $method=strtoupper($method);

        echo $method.$path;

    }
}
