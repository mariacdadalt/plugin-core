<?php

declare(strict_types=1);

namespace Plugin\Core\Abstractions;

abstract class AbstractFilter
{
    protected $args = [];

    abstract protected function modify(object $value): object;

    protected function shouldChange(): bool
    {
        return false;
    }

    public function filter(object $value, array $args = []): object
    {
        $this->args = $args;
        if ($this->shouldChange()) {
            return $this->modify($value);
        }
        return $value;
    }
}
