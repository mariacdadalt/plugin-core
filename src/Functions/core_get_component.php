<?php

/**
 * Shorthand function to get a component and render it;
 * @param string $key
 * @param array $args
 * @param string $view
 * @throws Exception
 */
function core_get_component( string $key, array $args = [], string $view = '' ) {
    $component = core()->get_component( $key );
    echo $component->render( $view, $args );
}