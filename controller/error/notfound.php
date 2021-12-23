<?php 

class ControllerErrorNotfound extends Controller
{
    public function index($data = [])
    {
        $this->document->setTitle('Page not found!');

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();
        
        $data['header'] = $header->index();
        $data['footer'] = $footer->index();

        $this->response->setResponseCode(404);
        $this->response->setOutput($this->view->get('error/404', $data));
    }
}