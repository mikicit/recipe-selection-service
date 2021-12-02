<?php 

class ControllerAccountLogin extends Controller
{
  public function index()
  {   
    $model_login = new ModelAccountLogin();

    $data = [];

    $this->document->setTitle('Login');

    $header = new ControllerCommonHeader();
    $footer = new ControllerCommonFooter();

    $data['header'] = $header->index();
    $data['footer'] = $footer->index();

    ## POST processing
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $form_data = [];

      $form_data['password'] = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
      $form_data['email']    = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
      
      ## Password
      if (strlen($form_data['password']) == 0) {
        $data['form_error'] = 'Enter the correct password and email.';
      }

      ## Email
      if (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
        $data['form_error'] = 'Enter the correct password and email.';
      }

      if (!isset($data['form_error'])) {
        $user = $model_login->getUser($form_data['email']);

        if (empty($user)) {
          $data['form_error'] = 'Enter the correct password and email.';
        } else {
          $result = password_verify($form_data['password'], $user['password']);

          if ($result) {
            $_SESSION['user'] = $user;
            $this->response->redirect('/profile');
          } else {
            $data['form_error'] = 'Enter the correct password and email.';
          }
        }
      }
    }

    $this->response->setOutput($this->view->get('account/login', $data));
  }
}