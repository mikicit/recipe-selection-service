<?php 

namespace controller;

class Login extends \core\Controller
{
    private $data = [];
    private $model;
    private $view;

    public function __construct()
    {
        if (class_exists('\model\Login'))
        {
            $this->model = new \model\Login;
        }

        $this->view = new \core\View();

        $header = new Header();
        $footer = new Footer();

        $this->data['header'] = $header->index();
        $this->data['footer'] = $footer->index();
    }

    public function index()
    {
        echo $this->view->get('auth/login', $this->data);
    }
}