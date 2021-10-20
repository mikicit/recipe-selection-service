<?php

spl_autoload_register(function($class) {
    $path = ROOT . '/' .  $class . '.php';

    if (file_exists($path))
    {
        include(ROOT . '/' .  $class . '.php');
    }
});