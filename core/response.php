<?php

/**
 * [Description Response]
 */
class Response 
{
    public function setOutput($output)
    {
        echo $output;
        die();
    }

    public function setResponseCode($code)
    {
        http_response_code($code);
    }

    public function redirect($url)
    {
        header("Location: $url");
        die();
    }

    public function redirectToRef()
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }
}