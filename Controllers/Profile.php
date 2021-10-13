<?php 

namespace Controller;

class Profile extends \Core\Controller
{
    private $data = [];
    private $model;
    private $view;

    public function __construct()
    {
        if (class_exists('\Model\Profile'))
        {
            $this->model = new \Model\Profile;
        }

        $this->view = new \Core\View();

        $header = new Header();
        $footer = new Footer();

        $this->data['header'] = $header->index();
        $this->data['footer'] = $footer->index();
    }

    public function index()
    {
        echo $this->view->get('profile', $this->data);
    }
}