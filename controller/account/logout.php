<?php 

class ControllerAccountLogout extends Controller
{
  public function index()
  {
    unset($_SESSION['user']);
    $this->response->redirect('/login');
  }
}