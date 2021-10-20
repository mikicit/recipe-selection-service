<?php 

namespace controller;

class NotFound extends \core\Controller
{
    private $data = [];
    private $model;
    private $view;

    public function __construct()
    {
        if (class_exists('\model\NotFound'))
        {
            $this->model = new \model\NotFound;
        }

        $this->view = new \core\View();

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