<?php 

namespace controller;

class Footer extends \core\Controller
{
    private $data = [];
    private $model;
    private $view;

    public function __construct()
    {
        if (class_exists('\model\Footer'))
        {
            $this->model = new \model\Footer;
        }

        $this->view = new \Core\View();
    }

    public function index()
    {
        return $this->view->get('layout/footer');
    }
}