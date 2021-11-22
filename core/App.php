<?php

class App
{
    public static $db;
    public static $response;
    public static $view;
    public static $router;

    public static function init()
    {
        self::$db = new Db();
        self::$response = new Response();
        self::$view = new View();
        self::$router = new Router();
        self::$router->run();
    }
}