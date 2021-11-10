<?php

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
        $controller_name = 'CommonHome';
        $action_name = 'index';

        if (!empty($request_string))
        {
            $matches = [];
            $data = [];
            $matched = 0;
     
            foreach ($this->routes as $route => $controller)
            {
                if (preg_match($route, $request_string, $matches))
                {   
                    $matched = 1;
                    $result = preg_replace($route, $controller, $matches)[0];
                    $array = explode('/', $result);

                    $controller_name = array_shift($array);
                    $action_name = array_shift($array);

                    if (!empty($array)) 
                    {
                       foreach($array as $value) 
                       {    
                            $tmp = explode(':', $value);
                            $data[$tmp[0]] = $tmp[1];
                       }
                    }

                    $this->runController($controller_name, $action_name, $data);
                }
            }

            if (!$matched)
            {
                $this->redirect404();
            }
        }
        else
        {
            $this->runController($controller_name, $action_name);
        }
    }

    private function runController($controller_name, $action_name, $data = [])
    {
        $controller_name = 'Controller' . $controller_name;
        $controller = new $controller_name;
        $controller->$action_name($data);
    }

    private function redirect404()
	{
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location:' . $host . '404');
        die();
    }
}