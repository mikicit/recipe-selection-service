<?php 

class ControllerAccountLogout extends Controller
{
    public function index()
    {
        App::$user->unAuth();
        $this->response->redirect('/login');
    }
}