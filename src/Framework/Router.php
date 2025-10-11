<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array  $routes = [];

    public function add(string $method = "GET", string $path)
    {
        $this->routes[] = [
            'path' => $this->normalizePath($path),
            'method' => strtoupper($method)
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
}
