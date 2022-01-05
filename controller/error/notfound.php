<?php 

/**
 * ControllerErrorNotfound
 * 
 * The controller is responsible for the 404 page.
 */
class ControllerErrorNotfound extends Controller
{
    /**
     * Processing get and post requests on the 404 page.
     * 
     * @param array $data
     * 
     * @return void
     */
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