<?php 

class ControllerAccountRegistration extends Controller
{
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_SESSION['user'])) $this->response->redirect('/profile');

            $model_registration = new ModelAccountRegistration();
            $data = [];

            ## session form data
            if (isset($_SESSION['form_data'])) {
                $data['form_data'] = $_SESSION['form_data'];
                unset($_SESSION['form_data']);
            }
    
            $this->document->setTitle('Registration');
    
            $header = new ControllerCommonHeader();
            $footer = new ControllerCommonFooter();
    
            $data['header'] = $header->index();
            $data['footer'] = $footer->index();

            $this->response->setOutput($this->view->get('account/registration', $data));
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_SESSION['user'])) return;

            $model_registration = new ModelAccountRegistration();
            $data = [];

            $data['password']  = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
            $data['firstname'] = isset($_POST['firstname']) ? trim(htmlspecialchars($_POST['firstname'])) : '';
            $data['lastname']  = isset($_POST['lastname']) ? trim(htmlspecialchars($_POST['lastname'])) : '';
            $data['email']     = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';

            $data['validation'] = [];

            ## Validation

            ## Firstname
            if (strlen($data['firstname']) < 2) {
                $data['validation']['firstname'] = 'Firstname must not be shorter than 2 characters.';
            }

            if (!preg_match("/^[a-zA-Z]*$/", $data['firstname'])) {
                $data['validation']['firstname'] = 'Only letters allowed.';
            }

            ## Lastname
            if (strlen($data['lastname']) < 2) {
                $data['validation']['lastname'] = 'Lastname must not be shorter than 2 characters.';
            }

            if (!preg_match("/^[a-zA-Z]*$/", $data['lastname'])) {
                $data['validation']['lastname'] = 'Only letters allowed.';
            }

            ## Email
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['validation']['email'] = 'Invalid email format.';
            }
            
            ## Passwotd
            if (strlen($data['password']) < 8) {
                $data['validation']['password'] = 'Password must not be shorter than 8 characters.';
            }

            if (empty($data['validation'])) {
                ## Check if email exists
                if ($model_registration->emailExists($data['email'])) {
                    $data['error'] = 'A user with this Email already exists.';
                }

                if (!isset($data['error'])) {
                    ## Hash with salt
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    $result = $model_registration->register([
                        'password'  => $data['password'],
                        'firstname' => $data['firstname'],
                        'lastname'  => $data['lastname'],
                        'email'     => $data['email']
                    ]);

                    $_SESSION['form_data']['registration_success'] = 'Congratulations, you have successfully registered. Enter your login details.';

                    if ($result) $this->response->redirect('/login');
                    $data['error'] = 'Something went wrong.';
                }
            }

            $_SESSION['form_data'] = $data;

            $this->response->redirect($_SERVER['REQUEST_URI']);
        }
    }
}