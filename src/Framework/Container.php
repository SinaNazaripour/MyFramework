<?php

declare(strict_types=1);

namespace Framework;

use App;

class Container
{
    private array $definitions = [];
    public function addDefinitions($newDefinitions)
    {
        dd($newDefinitions);
    }
}
