<?php

class Db
{
    private $connection;

    public function __construct()
    {
        $this->connection = new \PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME . ';charset=utf8', DBUSER, DBPASSWORD);
        // $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function pdo()
    {
        return $this->connection;
    }
}