<?php
header('Content-type: text/plain');
 
$types = array(
    'MR_SPECIALS' => 'mod_rewrite specials',
    'MR_HEADERS' => 'HTTP headers',
    'MR_REQUEST' => 'connection & request',
    'MR_SERVER' => 'server internals',
    'MR_SYSTEM' => 'system stuff',
);
 
foreach ($types as $prefix => $title) {
    echo "\n$title\n\n";
    $length = strlen($prefix);
    foreach ($_SERVER as $k => $v) {
        if (!strncmp($prefix, $k, $length)) {
            $name = substr($k, $length + 1);
            echo "\t$name = $v\n";
            unset($_SERVER[$k]);
        }
    }
}
