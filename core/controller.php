<?php

/**
 * [Description Controller]
 */
abstract class Controller 
{
    /**
     * @return mixed
     */
    public abstract function index();

    /**
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
            case 'request':
                return App::$request;
            case 'response':
                return App::$response;
            case 'document':
                return App::$document;
            case 'user':
                return App::$user;
        }
    }
}