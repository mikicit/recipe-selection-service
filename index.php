<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once('config.php');
require_once('config/autoload.php');

App::init();

// print_r(Url::getVars('https://stackoverflow.com/?page=43&test=32', ['test' => 443]));
// echo '</br>';
// print_r(Url::setVars('https://stackoverflow.com/?page=43&test=32', ['test' => 43]));