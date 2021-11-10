<?php 

class ControllerCommonHeader extends Controller
{
    public function index()
    {
        $view = new View();
        $data = [];
        
        return $view->get('common/header', $data);
    }
}