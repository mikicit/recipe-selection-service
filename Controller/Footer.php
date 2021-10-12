<?php 

namespace Controller;

use App\Controller;

class Footer extends Controller
{
    private $data = [];
    private $model;
    private $view;

    public function __construct()
    {
        $this->view = new \App\View();
    }

    private function view()
    {
       
    }

    public function index()
    {
        return $this->view->get('footer');
    }
}