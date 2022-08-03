<?php

/**
 * This function will get a class name from a file name.
 * @see https://stackoverflow.com/questions/7153000/get-class-name-from-file/44654073
 *
 * @param $file
 * @return mixed|string
 */
function core_tokenizer( string $file ) {
    $fp = fopen($file, 'r');
    $namespace = '';
    $class = $buffer = '';
    $i = 0;

    while (!$class) {
        if (feof($fp)) break;

        $buffer .= fread($fp, 512);
        $tokens = token_get_all($buffer);

        if (strpos($buffer, '{') === false) continue;

        for (;$i<count($tokens);$i++) {
            if($tokens[$i][0] === T_NAMESPACE) {
                for ($j=$i+1;$j<count($tokens);$j++) {
                    if ($tokens[$j] === ';') {
                        break;
                    }
                    if ($tokens[$j][1] === ' ') {
                        continue;
                    }
                    $namespace .= $tokens[$j][1];
                }
            }
            if ($tokens[$i][0] === T_CLASS) {
                for ($j=$i+1;$j<count($tokens);$j++) {
                    if ($tokens[$j] === '{') {
                        $class = $tokens[$i+2][1];
                    }
                }
            }
        }
    }

    return '\\' . $namespace . '\\' . $class;
}
