<?php

/**
 * [Description Request]
 */
class Request 
{
    /**
     * @var array
     */
    private $query_vars = [];

    /**
     * @param string $name
     * 
     * @return mixed
     */
    public function getQueryVar(string $name)
    {
        return isset($query_vars[$name]) ? $query_vars[$name] : null;
    }

    /**
     * @return array
     */
    public function getQueryVars()
    {
        return $this->query_vars;
    }

    /**
     * @param string $name
     * @param mixed $value
     * 
     * @return mixed
     */
    public function addQueryVar(string $name, $value)
    {
        $query_vars[$name] = $value;
    }

    /**
     * @param array $vars
     * 
     * @return void
     */
    public function addQueryVars(array $vars)
    {
        $this->query_vars = array_merge($this->query_vars, $vars);
    }
}