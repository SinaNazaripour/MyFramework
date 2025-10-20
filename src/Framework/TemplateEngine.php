<?php

declare(strict_types=1);

namespace Framework;

class TemplateEngine
{
    private $globalData = [];
    public function __construct(private string $basePath) {}

    public function render($path, array $data = [])
    {
        extract($data, EXTR_SKIP);
        extract($this->globalData, EXTR_SKIP);
        // $data = [...$data, ...$this->globalData];
        ob_start();
        include "{$this->resolve($path)}";

        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }

    public function resolve($path)
    {
        return "{$this->basePath}/{$path}";
    }

    public function addGlobalData($data)
    {
        $this->globalData = [...$data, ...$this->globalData];
    }
}
