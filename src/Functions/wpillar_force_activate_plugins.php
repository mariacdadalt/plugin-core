<?php

/**
 * Changes the array of active plugins to force activate the ones that
 * are required.
 *
 * @param mixed $plugins
 * @return mixed
 * @throws Exception
 */
function wpillar_get_active_plugins( $plugins ) {
    /*
    * Occasionally it seems a boolean can be passed in here.
    */
    if ( ! is_array( $plugins ) ) {
        return $plugins;
    }

    // Add our force-activated plugins
    $plugins = array_merge( (array) $plugins, wpillar()->get_dependencies() );

    // Deduplicate
    $plugins = array_unique( $plugins );

    return $plugins;

}

/**
 * Removes the activate/deactivate links from the plugins list
 * if they are in the force active or force deactive lists.
 *
 * @param array  $actions
 * @param string $plugin_file
 * @param array  $plugin_data
 * @param string $context
 *
 * @return array
 */
function wpillar_plugin_action_links( $actions, $plugin_file ) {

    if ( in_array( $plugin_file, wpillar()->get_dependencies(), true ) ) {
        unset( $actions['deactivate'] );
    }

    return $actions;
}
