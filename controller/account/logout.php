<?php 

class ControllerAccountLogout extends Controller
{
    public function index()
    {
        $this->user->unAuth();
        $this->response->redirect(Url::getUrl('/login'));
    }
}