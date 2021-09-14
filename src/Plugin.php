<?php


namespace WPillar\Core;


use WPillar\Core\Abstractions\Abstract_Plugin;

class Plugin extends Abstract_Plugin
{
    public static function set_constants(): void
    {
    }

    public static function get_dependencies(): array
    {
        return [
            'advanced-custom-fields-pro/acf.php',
        ];
    }
}
