<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once 'config.php';
require_once 'config/autoload.php';

$app = new \app\App();