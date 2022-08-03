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

if ( ! defined( 'PLUGIN_CORE_DIR' ) ) {
    define( 'PLUGIN_CORE_DIR', WP_CONTENT_DIR . '/mu-plugins/plugin-core/' );
}

if ( ! defined( 'PLUGIN_CORE_LANG' ) ) {
    define( 'PLUGIN_CORE_LANG', 'plugin-core' );
}

/**
 * Autoload utility functions
 */
function load_core_functions() {
    foreach ( glob( PLUGIN_CORE_DIR . '/src/Functions/*.php' ) as $file ) {
        require_once $file;
    }
}
load_core_functions();

/**
 * Shorthand to get the instance of our main core plugin class
 *
 * @return Plugin\Core\Core
 * @throws Exception
 */
function core() {
    return \Plugin\Core\Core::instance();
}

/**
 * Register the plugin instance for the Core Plugin.
 */
core()->register_plugin( new \Plugin\Core\Plugin() );

/**
 * Init the plugin after all plugins are loaded.
 */
add_action(
    'plugins_loaded',
    function () {
        core()->init();
    },
    99,
    0
);

/**
 * Force activate the required plugins.
 */
add_filter(
    'option_active_plugins',
    'core_get_active_plugins',
    10,
    1
);

/**
 * Remove the option to deactivate the plugins that are required.
 */
add_filter(
    'plugin_action_links',
    'core_plugin_action_links',
    99,
    2
);
