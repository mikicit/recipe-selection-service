<?php 

class ControllerAccountProfile extends Controller
{
    public function index()
    {
        $data = [];
        $data['user'] = App::$user->getCurrentUser();

        if (!($data['user'])) $this->response->redirect('/login');

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();

        $this->document->setTitle($data['user']['firstname'] . ' ' . $data['user']['lastname']);

        $data['header'] = $header->index();
        $data['footer'] = $footer->index();
        
        $this->response->setOutput($this->view->get('account/profile', $data));
    }
}