<?php

/**
 * Controller
 * 
 * The base abstract controller class. 
 * Defines the required minimum methods for inheritors 
 * as well as magic methods for gaining access to other objects.
 */
abstract class Controller 
{
    /**
     * Basic controller method. Typically used to display or return a view (template).
     * 
     * @return mixed
     */
    public abstract function index();

    /**
     * A magic method for referring to objects.
     * Made for more convenient access to objects from the controller, 
     * as well as for more convenient replacement of objects, if necessary, 
     * so that you do not have to change all calls to objects in the entire code.
     * 
     * @param string $property
     * 
     * @return object
     */
    public function __get(string $property)
    {
        switch ($property)
        {
            case 'view':
                return App::$view;
            case 'response':
                return App::$response;
            case 'document':
                return App::$document;
            case 'user':
                return App::$user;
        }
    }
}