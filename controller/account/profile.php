<?php 

class ControllerAccountProfile extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            $this->response->redirect('/login');
        }

        $data = [];

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();

        $this->document->setTitle($_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname']);

        $data['header'] = $header->index();
        $data['footer'] = $footer->index();
        
        $this->response->setOutput($this->view->get('account/profile', $data));
    }
}