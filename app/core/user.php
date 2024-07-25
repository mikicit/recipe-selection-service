<?php

/**
 * User
 * 
 * This class is responsible for user authentication.
 */
class User
{
    /**
     * User object
     * 
     * @var array|null
     */
    private $user = null;

    /**
     * @var ModelAccountUser
     */
    private $model_user;

    public function __construct()
    {
        $this->model_user = new ModelAccountUser();
        $this->auth();
    }

    /**
     * Returns a user object, or null if the user is not authenticated.
     * 
     * @return array|null
     */
    public function getCurrentUser()
    {
        return $this->user;
    }

    /**
     * Identifies the user based on the presence of his id in the session.
     * 
     * @return void
     */
    public function auth()
    {
        if (isset($_SESSION['uid'])) {
            $this->user = $this->model_user->getUserById($_SESSION['uid']);
        }
    }

    /**
     * Resets user authentication.
     * 
     * @return void
     */
    public function unAuth()
    {
        $this->user = null;
        unset($_SESSION['uid']);
    }
}