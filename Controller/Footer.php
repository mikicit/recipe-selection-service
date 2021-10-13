<?php 

namespace Controller;

class Footer extends \Core\Controller
{
    private $data = [];
    private $model;
    private $view;

    public function __construct()
    {
        if (class_exists('\Model\Footer'))
        {
            $this->model = new \Model\Footer;
        }

        $this->view = new \Core\View();
    }

    private function view()
    {
        
    }

    public function index()
    {
        return $this->view->get('footer');
    }
}