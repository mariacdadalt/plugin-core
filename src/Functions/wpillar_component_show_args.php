<?php

/**
 * Shorthand function for showing possible arguments for
 * a component.
 *
 * @param $key
 * @throws Exception
 */
function wpillar_component_show_args( $key ) {
    $component = wpillar()->get_component( $key );
    wpillar_d( $component->get_context() );
}