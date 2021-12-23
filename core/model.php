<?php

/**
 * [Description Model]
 */
abstract class Model 
{
    /**
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
                return $db->pdo();
        }
    }
}