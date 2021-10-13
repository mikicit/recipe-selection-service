<?php

namespace Core;

class App 
{
    private $DB;

    function __construct()
    {
        Router::start();
    }
}