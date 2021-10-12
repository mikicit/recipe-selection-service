<?php 

namespace Controller;

use App\Controller;

class Home extends Controller
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

        $this->view = new \App\View();

        $header = new Header();
        $footer = new Footer();

        $this->data['header'] = $header->index();
        $this->data['footer'] = $footer->index();
    }

    public function index()
    {
        print_r($this->view->get('home', $this->data));
    }
}