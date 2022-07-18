<?php

/**
 * App
 * 
 * The front controller contains links to the main objects (singletons) 
 * for managing the state of the application. 
 * It also initializes the session and transfers control to the router.
 */
class App
{
    /**
     * @var Db
     */
    public static Db $db;
    /**
     * @var User
     */
    public static User $user;
    /**
     * @var Document
     */
    public static Document $document;
    /**
     * @var Response
     */
    public static Response $response;
    /**
     * @var View
     */
    public static View $view;
    /**
     * @var Router
     */
    public static Router $router;

    /**
     * Application initialization.
     * 
     * @static
     * @return void
     */
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