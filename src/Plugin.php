<?php

declare(strict_types=1);

namespace Plugin\Core;

use Plugin\Core\Abstractions\AbstractPlugin;

class Plugin extends AbstractPlugin
{
    public function defineConstants(): void
    {
        if (! defined('PLUGIN_CORE_DIR')) {
            define('PLUGIN_CORE_DIR', WP_CONTENT_DIR . '/mu-plugins/plugin-core/');
        }

        if (! defined('PLUGIN_CORE_LANG')) {
            define('PLUGIN_CORE_LANG', 'plugin-core');
        }
    }

    public function dependencies(): array
    {
        return [];
    }
}
