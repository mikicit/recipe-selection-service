<?php

/**
 * Router
 * 
 * This class is responsible for parsing the request, matching with possible routes 
 * and transferring control to the appropriate controller.
 */
class Router
{
    /**
     * Routes from config file routes.php
     * 
     * @var array
     */
    private $routes = [];

    public function __construct()
    {
        ob_start();
        include('config/routes.php');
        $this->routes = $routes;
        ob_end_clean();
    }

    /**
     * 
     * 
     * @return void
     */
    public function run()
    {
        ## getting query string
        $request_string = trim(preg_replace('/\?.*/', '', $_SERVER['REQUEST_URI']), '/');
        $this->resolveRoute($request_string);
    }

    /**
     * This method receives a query string and parses it, if it finds a match in the routes, 
     * transfers control to the appropriate controller and its method 
     * with query parameters (in the form of an array), if any.
     * 
     * @param string $request_string
     * 
     * @return void
     */
    private function resolveRoute(string $request_string)
    {   
        ## base controller and action
        $controller_name = 'CommonHome';
        $action_name = 'index';

        if (!empty($request_string)) {
            $matches = [];
            $data    = [];
            $matched = 0;
     
            foreach ($this->routes as $route => $controller) {
                if (preg_match($route, $request_string, $matches)) {   
                    $matched = 1;
                    $result = preg_replace($route, $controller, $matches)[0];
                    $array = explode('/', $result);

                    $controller_name = array_shift($array);
                    $action_name = array_shift($array);

                    if (!empty($array)) {
                        foreach($array as $value) {    
                            $tmp = explode(':', $value);
                            $data[$tmp[0]] = $tmp[1];
                       }
                    }

                    $this->runController($controller_name, $action_name, $data);
                }
            }

            if (!$matched) {
                $this->runController('ErrorNotfound', 'index');
            }
        } else {
            $this->runController($controller_name, $action_name);
        }
    }

    /**
     * Transfer of control to the controller.
     * 
     * @param string $controller_name
     * @param string $action_name
     * @param array $data
     * 
     * @return void
     */
    private function runController(string $controller_name, string $action_name, array $data = [])
    {
        $controller_name = 'Controller' . $controller_name;
        $controller = new $controller_name;
        $controller->$action_name($data);
    }
}