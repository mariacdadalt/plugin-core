<?php

/**
 * This function lists the currently defined constants.
 * Other possible categories are: all, core, pcre
 *
 * @param string $category Default for 'user'.
 */
function wpillar_list_defined_constants( $category = 'user') {
    echo "<pre style='background-color:white'>";
    if ( 'all' == $category ) {
        print_r(get_defined_constants(true));
    } else {
        $constants = get_defined_constants(true);
        print_r( $constants[$category] );
    }
    echo "</pre>";
}
