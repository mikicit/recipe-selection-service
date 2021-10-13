<?php 

namespace Controller;

class NotFound extends \Core\Controllers
{
    private $data = [];
    private $model;
    private $view;

    public function __construct()
    {
        if (class_exists('\Model\NotFound'))
        {
            $this->model = new \Model\NotFound;
        }

        $this->view = new \Core\View();

        $header = new Header();
        $footer = new Footer();

        $this->data['header'] = $header->index();
        $this->data['footer'] = $footer->index();
    }

    public function index()
    {
        echo $this->view->get('404', $this->data);
    }
}