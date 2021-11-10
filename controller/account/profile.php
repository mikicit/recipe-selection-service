<?php 

class ControllerAccountProfile extends Controller
{
    private $data = [];
    private $model;
    private $view;

    public function __construct()
    {
        $this->view = new View();

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();

        $this->data['header'] = $header->index();
        $this->data['footer'] = $footer->index();
    }

    public function index()
    {
        echo $this->view->get('user/profile', $this->data);
    }

    public function show() {
        
    }
}