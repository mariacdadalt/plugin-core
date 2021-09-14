<?php

/**
 * Helper function to dump data in a readable way.
 *
 * @param $data
 */
function wpillar_d( $data ) {
    highlight_string("<?php\n\$data =\n" . var_export($data, true) . ";\n?>");
}
