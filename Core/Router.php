<?php

namespace Core;

class Router
{
    private $routes = [];

    public function __construct()
    {
        ob_start();

        include('config/routes.php');

        $this->routes = $routes;

        ob_end_clean();
    }

    public function run()
    {
        $request_string = trim(preg_replace('/\?.*/', '', $_SERVER['REQUEST_URI']), '/');

        $this->resolveRoute($request_string);
    }

    private function resolveRoute($request_string)
    {   
        $controller_name = 'Home';
        $action_name = 'index';

        // $route = '/profile\/test\/(\d+)/';
        // $request_string = 'profile/test/23';

        // $matches = [];

        // print_r(preg_match($route, $request_string, $matches));
        // print_r($matches);
        // die();

        if (!empty($request_string))
        {
            $matches = [];

            foreach ($this->routes as $route => $controller)
            {
                if (preg_match($route, $request_string, $matches))
                {
                    // print_r($matches);
                    // die();

                    $array = explode('/', $controller);

                    $controller_name = $array[0];

                    if (!empty($array[1]))
                    {
                        $action_name = $array[1];
                    }

                    $this->runController($controller_name, $action_name);
                }
            }
        }
        else
        {
            $this->runController($controller_name, $action_name);
        }


        // if (!empty($request_string)) {
        //     if (array_key_exists($request_string, $this->routes))
        //     {   
        //         $route = $this->routes[$request_string];
        //         $controller_name = '\\controller\\' . $route['controller'];

        //         if (!empty($route['action']))
        //         {
        //             $action_name = $route['action'];
        //         }

        //         $controller = new $controller_name;
        //         $controller->$action_name();
        //     }
        //     else
        //     {
        //         $this->redirect404();
        //     }
        // }
        // else
        // {
        //     $controller_name = '\\controller\\' . $controller_name;
        //     $controller = new $controller_name;
        //     $controller->$action_name();
        // }

       
    }

    private function runController($controller_name, $action_name)
    {
        $controller_name = '\\controller\\' . $controller_name;
        $controller = new $controller_name;
        $controller->$action_name();
    }

    private function redirect404()
	{
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location:' . $host . '404');
    }
}