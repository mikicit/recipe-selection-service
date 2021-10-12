<?php 

namespace Controller;

use App\Controller;

class Header extends Controller
{
    private $data = [];
    private $model;
    private $view;

    public function __construct()
    {
        $this->view = new \App\View();
    }

    public function index()
    {
        return $this->view->get('header', $this->data);
    }
}