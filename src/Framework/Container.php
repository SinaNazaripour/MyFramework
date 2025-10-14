<?php

declare(strict_types=1);

namespace Framework;

use App;
use Framework\Exceptions\ContainerException;
use ReflectionClass;
use ReflectionNamedType;

class Container
{
    private array $definitions = [];

    public function addDefinitions($newDefinitions)
    {
        $this->definitions = [...$this->definitions, ...$newDefinitions];
    }


    public function resolve(string $className)
    {
        $reflactionClass = new ReflectionClass($className);
        if (!$reflactionClass->isInstantiable()) {
            throw new ContainerException("Class {$className} is not instantiable!");
        }

        $constructor = $reflactionClass->getConstructor();
        if (!$constructor) {
            return new $className;
        }

        $params = $constructor->getParameters();
        if (count($params) === 0) {
            return new $className;
        }

        foreach ($params as $param) {
            $name = $param->getName();
            $type = $param->getType();

            if (!$type) {
                throw new ContainerException("Fail to resolve class{$className} becuse the param {$name} is missing a type hint.");
            }

            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                throw new ContainerException("Fail to resolve class{$className} becuse the param {$name} is not valid.");
            }

            $dependencies[] = $this->get($type->getName());
        }
        return $reflactionClass->newInstanceArgs($dependencies);
    }

    public function get(string $id)
    {
        if (!array_key_exists($id, $this->definitions)) {
            throw new ContainerException("class{$id} is not defined in container.");
        }

        $factory = $this->definitions[$id];
        $dependency = $factory();
        return $dependency;
    }
}
