<?php
spl_autoload_register(function ($class) {

    $sources = array('/_cms_/engine/lib/');

    foreach ($sources as $source) {
        $source = $_SERVER['DOCUMENT_ROOT'] . $source . $class . '.php';
        if (file_exists($source)) {
            require_once $source;
            break;
        }
    }
});

?>