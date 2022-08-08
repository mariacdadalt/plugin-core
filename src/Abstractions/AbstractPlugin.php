<?php

declare(strict_types=1);

namespace Plugin\Core\Abstractions;

abstract class AbstractPlugin
{
    public function subscribers(): array
    {

        $reflectionClass = new \ReflectionClass(get_called_class());

        $classArray = [];
        foreach (
            glob(dirname($reflectionClass->getFileName()) .
            '/Services/**/*Subscriber.php') as $file
        ) {
            $classArray[] = core()->tokenizer($file);
        }
        return $classArray;
    }

    public function definers(): array
    {

        $reflectionClass = new \ReflectionClass(get_called_class());

        $classArray = [];
        foreach (
            glob(dirname($reflectionClass->getFileName()) .
            '/Services/**/*Definer.php') as $file
        ) {
            $classArray[] = core()->tokenizer($file);
        }
        return $classArray;
    }

    public function runners(): array
    {

        $reflectionClass = new \ReflectionClass(get_called_class());

        $classArray = [];
        foreach (
            glob(dirname($reflectionClass->getFileName()) .
            '/Services/**/*Runner.php') as $file
        ) {
            $classArray[] = core()->tokenizer($file);
        }
        return $classArray;
    }

    public function components(): array
    {

        $reflectionClass = new \ReflectionClass(get_called_class());

        $componentArray = [];
        foreach (
            glob(dirname($reflectionClass->getFileName()) .
            '/Components/**/*Component.php') as $file
        ) {
            $componentClass = core()->tokenizer($file);
            $componentArray[ $componentClass::key() ] = $componentClass;
        }
        return $componentArray;
    }

    public function cpts(): array
    {
        $reflectionClass = new \ReflectionClass(get_called_class());

        $classArray = [];
        foreach (
            glob(dirname($reflectionClass->getFileName()) .
            '/Services/**/*CPT.php') as $file
        ) {
            $classArray[] = core()->tokenizer($file);
        }
        return $classArray;
    }

    abstract public function defineConstants(): void;

    abstract public function dependencies(): array;
}
