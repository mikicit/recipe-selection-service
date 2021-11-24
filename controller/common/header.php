<?php 

class ControllerCommonHeader extends Controller
{
    public function index()
    {
        $view = new View();
        $data = [];

        $data['title'] = $this->document->getTitle();
        
        return $view->get('common/header', $data);
    }
}