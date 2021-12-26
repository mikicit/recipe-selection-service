<?php 

class ControllerAccountLogin extends Controller
{
	public function index($data = [])
	{   
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			if ($this->user->getCurrentUser()) $this->response->redirect(Url::getUrl('/profile'));

            $this->document->setTitle('Login');

			## session form data
			if (isset($_SESSION['form_data'])) {
				$data['form_data'] = $_SESSION['form_data'];
				unset($_SESSION['form_data']);
			}

			$header = new ControllerCommonHeader();
			$footer = new ControllerCommonFooter();

			$data['header'] = $header->index();
			$data['footer'] = $footer->index();

			$this->response->setOutput($this->view->get('account/login', $data));
		} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST['login'])) {
				if ($this->user->getCurrentUser()) $this->response->redirect(Url::getUrl('/profile'));

				$model_user = new ModelAccountUser();

				## Removing html tags
				$data['password'] = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
				$data['email']    = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
				
				## validation
				$data['error'] = (function(& $data, $model_user) {
					$error_msg = 'Enter the correct password and email.';

					## Password
					if (strlen($data['password']) == 0) {
						return $error_msg;
					}

					## Email
					if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
						return $error_msg;
					}

					## User's existence
					$user = $model_user->getUserByEmail($data['email']);

					if (empty($user)) {
						return $error_msg;
					} 

					## Password verification
					$result = password_verify($data['password'], $user['password']);

					if (!$result) return $error_msg;

					$_SESSION['uid'] = $user['user_id'];
					$this->response->redirect(Url::getUrl('/profile'));
				})($data, $model_user);

				$_SESSION['form_data'] = [
					'error' => $data['error'],
					'email' => $data['email']
				];

				$this->response->redirect(Url::getCurrentUrl());
			}
		}
	}
}