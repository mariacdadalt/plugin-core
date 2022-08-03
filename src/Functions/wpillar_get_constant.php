<?php

/**
 * This function will return your constant value, or a default value, if not defined.
 *
 * @param $name
 * @param null $default
 * @return int|mixed|string|null
 */
function core_get_constant($name, $default = null ) {
    if ( ! defined( $name ) ) {
        return $default;
    }

    $value = constant( $name );

    if ( empty( $value ) ) {
        return $default;
    }

    $value_str = strtolower( trim( $value ) );
    if ( 'false' === $value_str || 'true' === $value_str ) {
        return filter_var( $value_str, FILTER_VALIDATE_BOOLEAN );
    }

    if ( is_numeric( $value ) ) {
        return ( $value - 0 );
    }

    return $value;
}
