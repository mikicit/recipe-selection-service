<?php

class User
{
    private $user = null;
    private $model_user;

    public function __construct()
    {
        $this->model_user = new ModelAccountUser();
        $this->auth();
    }

    public function getCurrentUser()
    {
        return $this->user;
    }

    public function isAuth()
    {
        return $this->user ? true : false;
    }

    public function auth()
    {
        if (isset($_SESSION['uid'])) {
            $this->user = $this->model_user->getUserById($_SESSION['uid']);
        }
    }

    public function unAuth()
    {
        $this->usert = null;
        unset($_SESSION['uid']);
    }
}