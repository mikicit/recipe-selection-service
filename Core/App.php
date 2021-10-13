<?php

namespace Core;

class App 
{
    private static $DB;

    public static function init()
    {
        Router::start();
    }

    private static function initRoutes()
    {
        ob_start();

        include('Configs/routes.php');

        self::$routes = $routes;

        ob_end_clean();
    }

    private static function initDbConnection()
    {

    }

    public static function getRoutes()
    {
        return self::$routes;
    }

}