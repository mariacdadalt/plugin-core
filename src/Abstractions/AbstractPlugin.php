<?php

declare(strict_types=1);

namespace Plugin\Core\Abstractions;

abstract class AbstractPlugin
{
    /**
    * "abstract" declaration on a version constant.
    * Requires you to set the constant in your implementation.
    */
    public const VERSION = self::VERSION;
    public const NAME = self::NAME;

    protected string $fileName = '';

    public function __construct()
    {
        $reflectionClass = new \ReflectionClass(get_called_class());
        $this->fileName = $reflectionClass->getFileName();
    }

    /**
     * Returns the PATH of the plugin, without a / at the end.
     */
    public function path(): string
    {
        return dirname(plugin_dir_path($this->fileName));
    }

    /**
     * Returns the URL of the plugin, with a / at the end.
     */
    public function url(): string
    {
        return plugin_dir_url(dirname($this->fileName));
    }

    public function subscribers(): array
    {
        $classArray = [];
        foreach (glob($this->path() . '/Services/**/*Subscriber.php') as $file) {
            $classArray[] = core()->tokenizer($file);
        }
        return $classArray;
    }

    public function definers(): array
    {
        $classArray = [];
        foreach (glob($this->path() . '/Services/**/*Definer.php') as $file) {
            $classArray[] = core()->tokenizer($file);
        }
        return $classArray;
    }

    public function runners(): array
    {
        $classArray = [];
        foreach (glob($this->path() . '/Services/**/*Runner.php') as $file) {
            $classArray[] = core()->tokenizer($file);
        }
        return $classArray;
    }

    public function components(): array
    {
        $componentArray = [];
        foreach (glob($this->path() . '/Components/**/*Component.php') as $file) {
            $componentClass = core()->tokenizer($file);
            $componentArray[ $componentClass::key() ] = $componentClass;
        }
        return $componentArray;
    }

    public function cpts(): array
    {
        $classArray = [];
        foreach (glob($this->path() . '/Services/**/*CPT.php') as $file) {
            $classArray[] = core()->tokenizer($file);
        }
        return $classArray;
    }

    public function scripts(): void
    {
        $directory = $this->path() . '/dist/';
        if (!file_exists($directory)) {
            return;
        }
        chdir($directory);
        foreach (glob('*.{js,JS}', GLOB_BRACE) as $file) {
            wp_enqueue_script($this::NAME . '-JS', $this->url() . 'dist/' . $file, [ 'jquery' ], $this::VERSION, true);
        }
    }

    public function styles(): void
    {
        $directory = $this->path() . '/dist/';
        if (!file_exists($directory)) {
            return;
        }
        chdir($directory);
        foreach (
            glob('*.{css,CSS}', GLOB_BRACE) as $file
        ) {
            wp_enqueue_style($this::NAME . '-CSS', $this->url() . 'dist/' . $file, [], $this::VERSION, 'all');
        }
    }

    abstract public function defineConstants(): void;

    abstract public function dependencies(): array;
}
