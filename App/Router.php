<?php

namespace App;

class Router
{
    public static function start()
    {
        $controller_name = 'Home';
        $action_name = 'index';

        $routes = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

        if (!empty($routes[0]))
        {
            $conrtoller_name = $routes[0];
        }

        if (!empty($routes[1]))
        {
            $action_name = $routes[1];
        }

        $controller_path = '\controller\\' . $controller_name;

        if (class_exists($controller_path))
        {
            $controller = new $controller_path;
            $controller->$action_name();
        }
        else
        {
            self::error404();
        }
    }

    private static function error404()
	{
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location:' . $host . '404');
    }
}