<?php

declare(strict_types=1);

namespace Plugin\Core\Abstractions;

abstract class AbstractHandler
{
    abstract public function handle(): void;
}
