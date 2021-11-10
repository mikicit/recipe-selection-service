<?php

class App
{
    public static $db;
    private static $router;

    public static function init()
    {
        self::$db = new Db();
        self::$router = new Router();
        self::$router->run();
    }
}