<?php 

class ControllerAccountRegistration extends Controller
{
    public function index()
    {
        $view = new View();
        $data = [];

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();

        $data['header'] = $header->index();
        $data['footer'] = $footer->index();

        echo $view->get('account/registration', $data);
    }
}