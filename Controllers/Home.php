<?php 

namespace Controller;

class Home extends \Core\Controllers
{
    private $data = [];
    private $model;
    private $view;

    public function __construct()
    {
        if (class_exists('\Model\Home'))
        {
            $this->model = new \Model\Home;
        }

        $this->view = new \Core\View();

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