<?php

declare(strict_types=1);

namespace Plugin\Core\Abstractions;

/**
 * The classes that extends this
 * will define dependencies for the PHP_DI.
 */
abstract class AbstractDefiner
{
    abstract public function define(): array;
}
