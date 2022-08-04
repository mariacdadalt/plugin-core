<?php

declare(strict_types=1);

namespace Plugin\Core\Abstractions;

abstract class AbstractRenderer
{
    protected $subDirectory;
    protected $sharedDir;

    public function subDirectory(string $dir): void
    {
        $this->subDirectory = $dir;
    }

    public function sharedDir(string $dir): void
    {
        $this->sharedDir = $dir;
    }

    abstract public function args(array $args);

    abstract public function render();

    abstract public function shared();
}
