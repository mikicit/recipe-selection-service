<?php

abstract class Model {
    public function __get($property)
    {
        switch ($property)
        {
            case 'db':
                $db = App::$db;
                return $db->pdo();
        }
    }
}