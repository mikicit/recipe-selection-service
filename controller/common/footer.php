<?php 

class ControllerCommonFooter extends Controller
{
    public function index()
    {
        $data = [];

        return $this->view->get('common/footer', $data);
    }
}