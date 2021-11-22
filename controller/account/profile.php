<?php 

class ControllerAccountProfile extends Controller
{
    public function index()
    {
        $data = [];

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();

        $data['header'] = $header->index();
        $data['footer'] = $footer->index();
        
        $this->response->setOutput($this->view->get('account/profile', $data));
    }
}