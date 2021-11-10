<?php

class Db
{
    private $connection;

    public function __construct()
    {
        $this->connection = new \PDO('mysql:host=remotemysql.com;dbname=mR0KM36tCK;charset=utf8', 'mR0KM36tCK', 'Z8QDmiEx0h');
    }

    public function query($query)
    {
        return $this->connection->query($query);
    }
}