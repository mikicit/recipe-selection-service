<?php

spl_autoload_register(function($class) {
    $parts = preg_split('/(?=[A-Z])/', $class, -1, PREG_SPLIT_NO_EMPTY);

    if (count($parts) == 1)
    {   
        $path = ROOT . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . strtolower($parts[0]) . '.php';
        if (file_exists($path))
        {
            include($path);
        }
    }
    else
    {
        $path = ROOT . DIRECTORY_SEPARATOR . strtolower(implode(DIRECTORY_SEPARATOR, $parts)) . '.php';

        if (file_exists($path))
        {
            include($path);
        }
    }
});