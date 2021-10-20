<?php

namespace Core;

class App 
{
    private static $DB;
    private static $router;

    public static function init()
    {
        self::$DB = new DB();
        self::$router = new Router();

        self::initDbConnection();
        self::$router->run();
    }

    private static function initDbConnection()
    {

    }
}