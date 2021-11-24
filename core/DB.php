<?php

class Db
{
    private $connection;

    public function __construct()
    {   
        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $dsn = 'mysql:host=' . DBHOST . ';dbname=' . DBNAME . ';charset=utf8';

        $this->connection = new \PDO($dsn, DBUSER, DBPASSWORD, $options);
    }

    public function pdo()
    {
        return $this->connection;
    }
}