<?php

declare(strict_types=1);

namespace Plugin\Core;

use Plugin\Core\Abstractions\AbstractPlugin;

class Plugin extends AbstractPlugin
{
    public const NAME = 'core';
    public const VERSION = '1.0';

    public function defineConstants(): void
    {
        if (! defined('PLUGIN_CORE_LANG')) {
            define('PLUGIN_CORE_LANG', 'plugin-core');
        }
    }

    public function dependencies(): array
    {
        return [];
    }
}
