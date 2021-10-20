<?php 

namespace controller;

class Header extends \core\Controller
{
    private $data = [];
    private $model;
    private $view;

    public function __construct()
    {
        if (class_exists('\model\Header'))
        {
            $this->model = new \model\Header;
        }

        $this->view = new \Core\View();
    }

    public function index()
    {
        return $this->view->get('layout/header', $this->data);
    }
}