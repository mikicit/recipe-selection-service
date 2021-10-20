<?php 

namespace controller;

class Home extends \core\Controller
{
    private $data = [];
    private $model;
    private $view;

    public function __construct()
    {
        if (class_exists('\model\Home'))
        {
            $this->model = new \model\Home;
        }

        $this->view = new \core\View();

        $header = new Header();
        $footer = new Footer();

        $this->data['header'] = $header->index();
        $this->data['footer'] = $footer->index();
    }

    public function index()
    {
        echo $this->view->get('home', $this->data);
    }
}