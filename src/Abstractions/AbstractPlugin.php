<?php

declare(strict_types=1);

namespace Plugin\Core\Abstractions;

abstract class AbstractPlugin
{
    public function loadSubscribers(): array
    {

        $reflectionClass = new \ReflectionClass(get_called_class());

        $classArray = [];
        foreach (
            glob(dirname($reflectionClass->getFileName()) .
            '/Services/**/*_Subscriber.php') as $file
        ) {
            $classArray[] = core_tokenizer($file);
        }
        return $classArray;
    }

    public function loadDefiners(): array
    {

        $reflectionClass = new \ReflectionClass(get_called_class());

        $classArray = [];
        foreach (
            glob(dirname($reflectionClass->getFileName()) .
            '/Services/**/*_Definer.php') as $file
        ) {
            $classArray[] = core_tokenizer($file);
        }
        return $classArray;
    }

    public function loadRunners(): array
    {

        $reflectionClass = new \ReflectionClass(get_called_class());

        $classArray = [];
        foreach (
            glob(dirname($reflectionClass->getFileName()) .
            '/Services/**/*_Runner.php') as $file
        ) {
            $classArray[] = core_tokenizer($file);
        }
        return $classArray;
    }

    public function loadComponents(): array
    {

        $reflectionClass = new \ReflectionClass(get_called_class());

        $componentArray = [];
        foreach (
            glob(dirname($reflectionClass->getFileName()) .
            '/Components/**/*_Component.php') as $file
        ) {
            $componentClass = core_tokenizer($file);
            $componentArray[ $componentClass::key() ] = $componentClass;
        }
        return $componentArray;
    }

    public function loadCpts(): array
    {

        $reflectionClass = new \ReflectionClass(get_called_class());

        $classArray = [];
        foreach (
            glob(dirname($reflectionClass->getFileName()) .
            '/Services/**/*_CPT.php') as $file
        ) {
            $classArray[] = core_tokenizer($file);
        }
        return $classArray;
    }

    public function loadFunctions()
    {

        $reflectionClass = new \ReflectionClass(get_called_class());

        foreach (
            glob(dirname($reflectionClass->getFileName()) .
            '/Functions/*.php') as $file
        ) {
            require_once $file;
        }
    }

    abstract public function defineConstants(): void;

    abstract public function loadDependencies(): array;
}
