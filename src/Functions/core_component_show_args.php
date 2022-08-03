<?php

/**
 * Shorthand function for showing possible arguments for
 * a component.
 *
 * @param $key
 * @throws Exception
 */
function core_component_show_args( $key ) {
    $component = core()->get_component( $key );
    core_d( $component->get_context() );
}