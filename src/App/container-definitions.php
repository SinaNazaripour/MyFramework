<?php

declare(strict_types=1);

use App\Config\Paths;
use Framework\TemplateEngine;
use App\Services\ValidatorService;

return [
    TemplateEngine::class => fn() => new TemplateEngine(Paths::VIEW),
    ValidatorService::class => fn() => new ValidatorService(),
];
