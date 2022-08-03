<?php

/**
 * Helper function to concatenate an array of arguments
 *
 * @param array|null $attrs
 * @param string $prefix
 * @return string
 */
function core_concat_attrs( array $attrs = null, $prefix = '' ) {
    if ( empty( $attrs ) ) {
        return '';
    }
    $out    = [];
    $prefix = empty( $prefix ) ? '' : rtrim( $prefix, '-' ) . '-';
    foreach ( $attrs as $key => $value ) {
        if ( is_array( $value ) ) {
            $out[] = core_concat_attrs( $value, $key );
        } else {
            $out[] = sprintf( '%s="%s"', $prefix . $key, esc_attr( $value ) );
        }
    }

    return implode( ' ', $out );
}