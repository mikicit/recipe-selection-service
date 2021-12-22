<?php

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

    public function setHeader()
    {

    }

    public function redirect($diraction)
    {
        $url = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $diraction;

        header("Location: $url");
        die();
    }

    public function redirectToRef()
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }
}