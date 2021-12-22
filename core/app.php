<?php

class App
{
    public static $db;
    public static $user;
    public static $document;
    public static $response;
    public static $view;
    public static $router;

    public static function init()
    {
        session_start();

        self::$db = new Db();
        self::$user = new User();
        self::$document = new Document();
        self::$response = new Response();
        self::$view = new View();
        self::$router = new Router();

        self::$router->run();
    }
}