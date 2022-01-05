<?php

/**
 * The main entry point to the application.
 * 
 * PHP environment variables are being installed, configuration files 
 * are being connected, and the front controller is being launched.
 */

## PHP settings
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

ini_set('session.gc_maxlifetime', 86400);
ini_set('session.cookie_lifetime', 0);
session_set_cookie_params(0);

## Config
require_once('config.php');
require_once('config/autoload.php');

## Initializing the front controller
App::init();