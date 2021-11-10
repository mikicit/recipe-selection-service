<?php 

class ControllerCommonFooter extends Controller
{
    public function index()
    {
        $view = new View();
        $data = [];

        return $view->get('common/footer', $data);
    }
}