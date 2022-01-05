<?php

/**
 * Registering your own class autoloading functions.
 */

 
/**
 * This function is responsible for the logic of class autoloading. 
 * First, it tries to connect the class from the core directory, if nothing is found there, 
 * it tries to parse the function name into a path (the directories are separated using the camel case).
 * 
 * @param string $class Class name
 * 
 * @return void
 */
function custom_autoload_function($class) {
    $parts = preg_split('/(?=[A-Z])/', $class, -1, PREG_SPLIT_NO_EMPTY);

    ## finding in core
    if (count($parts) == 1) {   
        $path = ROOT . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . strtolower($parts[0]) . '.php';
        
        if (file_exists($path)) {
            include($path);
        }
    } else { ## Search based on the path derived from the class name (camel case)
        $path = ROOT . DIRECTORY_SEPARATOR . strtolower(implode(DIRECTORY_SEPARATOR, $parts)) . '.php';

        if (file_exists($path)) {
            include($path);
        }
    }
}

spl_autoload_register('custom_autoload_function');