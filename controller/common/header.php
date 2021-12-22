<?php 

class ControllerCommonHeader extends Controller
{
    public function index()
    {
        $data = [];

        $data['user'] = App::$user->getCurrentUser();
        $data['title'] = $this->document->getTitle();
        
        return $this->view->get('common/header', $data);
    }
}