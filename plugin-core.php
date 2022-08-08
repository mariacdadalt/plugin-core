<?php

/**
 * Plugin Name: Plugin Core
 * Plugin URI:
 * Description: A set of classes and interfaces to be used by other plugins.
 * Version: 1.0
 * Author: Maria C. Dadalt
 * Author URI:
 * License: MIT
 */

declare(strict_types=1);

//phpcs:disable NeutronStandard.Globals.DisallowGlobalFunctions.GlobalFunctions
//phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols

use Plugin\Core\Core;
use Plugin\Core\Plugin;

/**
 * Shorthand to get the instance of our main core plugin class
 *
 * @return Plugin\Core\Core
 * @throws Exception
 */
function core(): Core
{
    return Core::instance();
}

/**
 * Register the plugin instance for the Core Plugin.
 */
core()->registerPlugin(new Plugin());

/**
 * Start the core after all plugins have been registered.
 */
add_action(
    'plugins_loaded',
    static function () {
        core()->init();
    },
    99,
    0
);
