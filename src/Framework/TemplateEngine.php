<?php

declare(strict_types=1);

namespace Framework;

class TemplateEngine
{
    public function __construct(private string $basePath) {}

    public function render($path, array $data = [])
    {
        extract($data, EXTR_SKIP);
        ob_start();
        include "{$this->basePath}{$path}";

        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }
}
