<?php 

namespace controller;

class Profile extends \core\Controller
{
    private $data = [];
    private $model;
    private $view;

    public function __construct()
    {
        if (class_exists('\model\Profile'))
        {
            $this->model = new \model\Profile;
        }

        $this->view = new \Core\View();

        $header = new Header();
        $footer = new Footer();

        $this->data['header'] = $header->index();
        $this->data['footer'] = $footer->index();
    }

    public function index()
    {
        echo $this->view->get('user/profile', $this->data);
    }
}