<?php 

class ControllerAccountLogin extends Controller
{
    public function index()
    {
        $data = [];

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();

        $data['header'] = $header->index();
        $data['footer'] = $footer->index();

        echo $this->view->get('account/login', $data);
    }
}