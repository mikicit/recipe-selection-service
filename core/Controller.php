<?php

abstract class Controller 
{
    public abstract function index();

    public function __get($property)
    {
        switch ($property)
        {
            case 'view':
                return App::$view;
            case 'response':
                return App::$response;
            case 'document':
                return App::$document;
        }
    }
}