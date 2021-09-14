<?php
/**
 * Plugin Name: WPillar - Core Plugin
 * Version: 1.0
 */

if (!defined('WPILLAR_CORE_DIR')) {
    define('WPILLAR_CORE_DIR', WP_CONTENT_DIR . '/mu-plugins/wpillar-plugin-core/');
}

if (!defined('WPILLAR_LANG')) {
    define( 'WPILLAR_LANG', 'wpillar' );
}

/**
 * Autoload step functions
 */
function load_wpillar_core_functions() {
    foreach (glob(WPILLAR_CORE_DIR . '/src/Functions/*.php') as $file) {
        require_once $file;
    }
}
load_wpillar_core_functions();

/**
 * Shorthand to get the instance of our main core plugin class
 *
 * @return WPillar\Core\Core
 * @throws Exception
 */
function wpillar() {
    return \WPillar\Core\Core::instance();
}

/**
 * Register the plugin instance for the Core Plugin.
 */
wpillar()->register_plugin( new \WPillar\Core\Plugin() );

/**
 * Init the plugin after all plugins are loaded.
 */
add_action(
    'plugins_loaded',
    function () {
        wpillar()->init();
    },
    99,
    0
);

/**
 * Force activate the required plugins.
 */
add_filter(
    'option_active_plugins',
    'wpillar_get_active_plugins',
    10,
    1
);

/**
 * Remove the option to deactivate the plugins that are required.
 */
add_filter(
    'plugin_action_links',
    'wpillar_plugin_action_links',
    99,
    2
);
