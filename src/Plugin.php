<?php

declare(strict_types=1);

namespace Plugin\Core;

use Plugin\Core\Abstractions\AbstractPlugin;

class Plugin extends AbstractPlugin
{
    public function defineConstants(): void
    {
    }

    public function loadDependencies(): array
    {
        return [];
    }
}
