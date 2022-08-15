<?php

declare(strict_types=1);

namespace Plugin\Core\Abstractions;

abstract class AbstractRenderer
{
    protected $subDirectory;
    protected $sharedDir;
    protected $baseDir;

    public function subDirectory(string $dir): void
    {
        $this->subDirectory = $dir;
    }

    public function sharedDir(string $dir): void
    {
        $this->sharedDir = $dir;
    }

    public function baseDir(string $dir): void
    {
        $this->baseDir = $dir;
    }

    abstract public function render();

    abstract public function shared();
}
