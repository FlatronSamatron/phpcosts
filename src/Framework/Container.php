<?php

declare(strict_types=1);

namespace Framework;

use ReflectionClass, ReflectionNamedType;
use Framework\Exeptions\ContainerExeption;

class Container
{
    private array $defenitions = [];
    private array $resolved = [];

    public function addDefenition(array $newDefenition)
    {
        $this->defenitions = array_merge($this->defenitions, $newDefenition);
    }

    public function resolve(string $className)
    {

        $reflecctionClass = new ReflectionClass($className);

        if (!$reflecctionClass->isInstantiable()) {
            throw new ContainerExeption("Class {$className} is not instantiable");
        }

        $constructor = $reflecctionClass->getConstructor();

        if (!$constructor) {
            return new $className();
        }

        $params = $constructor->getParameters();

        if (count($params) === 0) {
            return new $className();
        }

        $dependencies = [];

        foreach ($params as $param) {
            $name = $param->getName();
            $type = $param->getType();

            if (!$type) {
                throw new ContainerExeption("Failed to resolve class {$className} because param {$name} is missing a type hint");
            }

            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                throw new ContainerExeption("Failed to resolve class {$className} because invalid param name");
            }

            $dependencies[] = $this->get($type->getName());
        }

        return $reflecctionClass->newInstanceArgs($dependencies);
    }

    public function get(string $id)
    {
        if(!array_key_exists($id, $this->defenitions)){
            throw new ContainerExeption("Class {$id} does not exist in container");
        }

        if(array_key_exists($id, $this->resolved)){
            return $this->resolved[$id];
        }

        $factory = $this->defenitions[$id];

        $defenitions = $factory();

        $this->resolved[$id] = $defenitions;
        return $defenitions; 
    }
}
