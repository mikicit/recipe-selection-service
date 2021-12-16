<?php 

class ControllerAccountLogin extends Controller
{
	public function index()
	{   
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$model_login = new ModelAccountLogin();
			$data = [];

			## session form data
            if (isset($_SESSION['form_data'])) {
                $data['form_data'] = $_SESSION['form_data'];
                unset($_SESSION['form_data']);
            }

			$this->document->setTitle('Login');

			$header = new ControllerCommonHeader();
			$footer = new ControllerCommonFooter();

			$data['header'] = $header->index();
			$data['footer'] = $footer->index();

			$this->response->setOutput($this->view->get('account/login', $data));
		} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$model_login = new ModelAccountLogin();
			$data = [];

			## getting POST data
			$data['password'] = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
			$data['email']    = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
			
			## validation

			## Password
			if (strlen($data['password']) == 0) {
				$data['error'] = 'Enter the correct password and email.';
			}

			## Email
			if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
				$data['error'] = 'Enter the correct password and email.';
			}

			if (!isset($data['error'])) {
				$user = $model_login->getUser($data['email']);

				if (empty($user)) {
					$data['error'] = 'Enter the correct password and email.';
				} else {
					$result = password_verify($data['password'], $user['password']);

					if ($result) {
						$_SESSION['user'] = $user;
						$this->response->redirect('/profile');
					} else {
						$data['error'] = 'Enter the correct password and email.';
					}
				}
			}

			$_SESSION['form_data']['error'] = $data['error'];

			$this->response->redirect($_SERVER['REQUEST_URI']);
		}
	}
}