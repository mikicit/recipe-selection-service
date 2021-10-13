<?php

namespace Core;

class Router
{
    private static $routes = [];

    public static function start()
    {
        $uri = trim($_SERVER['REQUEST_URI'], '/');

        self::resolveRoute($uri);
    }

    public static function addRoute($template, $controller)
    {
        $routes[$template] = $controller;
    }

    private static function resolveRoute($uri)
    {
        
    }

    private static function redirect404()
	{
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location:' . $host . '404');
    }
}