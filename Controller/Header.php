<?php 

namespace Controller;

class Header extends \Core\Controller
{
    private $data = [];
    private $model;
    private $view;

    public function __construct()
    {
        if (class_exists('\Model\Header'))
        {
            $this->model = new \Model\Header;
        }

        $this->view = new \Core\View();
    }

    public function index()
    {
        return $this->view->get('header', $this->data);
    }
}