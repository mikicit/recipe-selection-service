<?php

/**
 * Response
 * 
 * A single class for handling the response from the server to the client.
 * Contains auxiliary functions for displaying content, redirecting, setting response codes.
 */
class Response 
{
    /**
     * Sets the content of the response.
     * 
     * @param string $output
     * 
     * @return void
     */
    public function setOutput(string $output)
    {
        echo $output;
        die();
    }

    /**
     * Sets the server response code.
     * 
     * @param int $code
     * 
     * @return void
     */
    public function setResponseCode(int $code)
    {
        http_response_code($code);
    }

    /**
     * Redirects the request to the specified address.
     * 
     * @param string $url
     * 
     * @return void
     */
    public function redirect(string $url)
    {
        header("Location: $url");
        die();
    }

    /**
     * Redirects the request to the address from which the request came (by the referer).
     * 
     * @return void
     */
    public function redirectToRef()
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }

    /**
     * Sets a token to a session and returns it.
     * 
     * @return string
     */
    public function setToken()
    {
        $_SESSION['token'] = bin2hex(random_bytes(5));
        return $_SESSION['token'];
    }

    /**
     * Removes the token from the session.
     * 
     * @return void
     */
    public function unsetToken()
    {
        unset($_SESSION['token']);
    }
}