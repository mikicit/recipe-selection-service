<?php 

class ControllerAccountProfile extends Controller
{
    public function index($data = [])
    {
        $data['user'] = $this->user->getCurrentUser();

        if (!($data['user'])) $this->response->redirect(Url::getUrl('/login'));

        $data['user']['fullname'] = $data['user']['firstname'] . ' ' . $data['user']['lastname'];

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();

        $this->document->setTitle($data['user']['fullname']);

        $data['header'] = $header->index();
        $data['footer'] = $footer->index();
        
        $this->response->setOutput($this->view->get('account/profile', $data));
    }
}