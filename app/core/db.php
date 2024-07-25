<?php

/**
 * Db
 * 
 * The class is responsible for configuring
 * and connecting to the database.
 */
class Db
{
    /**
     * Connection object.
     * 
     * @var object
     */
    private $connection;

    public function __construct()
    {   
        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $dsn = 'pgsql:host=' . DBHOST . ';port=' . DBPORT . ';dbname=' . DBNAME . ';options=\'-c client_encoding=utf8\'';

        $this->connection = new \PDO($dsn, DBUSER, DBPASSWORD, $options);
    }

    /**
     * Gets a connection object for managing the object that is responsible 
     * for querying the database.
     * 
     * @return object
     */
    public function connection()
    {
        return $this->connection;
    }
}