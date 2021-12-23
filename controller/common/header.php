<?php 

class ControllerCommonHeader extends Controller
{
    public function index()
    {
        $data = [];

        $data['query_vars'] = $this->request->getQueryVars();
        $data['user'] = App::$user->getCurrentUser();
        $data['title'] = $this->document->getTitle();
        
        return $this->view->get('common/header', $data);
    }
}