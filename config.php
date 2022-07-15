<?php

/**
 * Setting basic configuration data.
 * 
 * Defining global variables for working with paths, connecting to a database, and so on.
 */

## PATH
define('ROOT', __DIR__ );
define('BASE_URL', $_ENV["DOMAIN"]);

# DB
define('DBHOST', $_ENV["DB_HOST"]);
define('DBPORT', $_ENV["DB_PORT"]);
define('DBNAME', $_ENV["DB_NAME"]);
define('DBUSER', $_ENV["DB_USER"]);
define('DBPASSWORD', $_ENV["DB_PASSWORD"]);
