<?php

/**
 * Model
 * 
 * The base abstract model class. 
 * Defines the required minimum methods for inheritors 
 * as well as magic methods for gaining access to other objects.
 */
abstract class Model 
{
    /**
     * A magic method for referring to objects.
     * Made for more convenient access to objects from the model, 
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
            case 'db':
                $db = App::$db;
                return $db->connection();
        }
    }
}