<?php 

class ControllerAccountRegistration extends Controller
{
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            if ($this->user->getCurrentUser()) $this->response->redirect(Url::getUrl('/profile'));

            $data = [];
    
            $this->document->setTitle('Registration');
            
            ## session form data
            if (isset($_SESSION['form_data'])) {
                $data['form_data'] = $_SESSION['form_data'];
                unset($_SESSION['form_data']);
            }
            
            $header = new ControllerCommonHeader();
            $footer = new ControllerCommonFooter();
            
            $data['header'] = $header->index();
            $data['footer'] = $footer->index();

            $this->response->setOutput($this->view->get('account/registration', $data));
        } 
        elseif ($_SERVER['REQUEST_METHOD'] == 'POST') 
        {
            if ($this->user->getCurrentUser()) return;

            $model_user = new ModelAccountUser();
            $data = [];

            ## Removing html tags and spaces
            $data['password']  = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
            $data['firstname'] = isset($_POST['firstname']) ? trim(htmlspecialchars($_POST['firstname'])) : '';
            $data['lastname']  = isset($_POST['lastname']) ? trim(htmlspecialchars($_POST['lastname'])) : '';
            $data['email']     = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';

            ## Validation

            ## Firstname
            $data['validation']['firstname'] = (function(& $data) {
                if (strlen($data['firstname']) < 2) {
                    return 'Firstname must not be shorter than 2 characters.';
                }

                if (!preg_match("/^[a-zA-Z]*$/", $data['firstname'])) {
                    return 'Only letters allowed.';
                }
            })($data);

            ## Lastname
            $data['validation']['lastname'] = (function(& $data) {
                if (strlen($data['lastname']) < 2) {
                    return 'Lastname must not be shorter than 2 characters.';
                }
    
                if (!preg_match("/^[a-zA-Z]*$/", $data['lastname'])) {
                    return 'Only letters allowed.';
                }
            })($data);

            ## Email
            $data['validation']['email'] = (function(& $data) {
                if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    return 'Invalid email format.';
                }
            })($data);

            ## Password
            $data['validation']['password'] = (function(& $data) {
                if (strlen($data['password']) < 8) {
                    return 'Password must not be shorter than 8 characters.';
                }
            })($data);

            ## Deleting fields without errors
            $data['validation'] = array_filter($data['validation'], function($value) { return !empty($value); });

            if (empty($data['validation'])) {
                ## Check if email exists
                if ($model_user->getUserByEmail($data['email'])) {
                    $data['error'] = 'A user with this Email already exists.';
                }

                if (!isset($data['error'])) {
                    ## Hash with salt
                    $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);

                    $query_vars = [
                        'password'  => $password_hash,
                        'firstname' => $data['firstname'],
                        'lastname'  => $data['lastname'],
                        'email'     => $data['email']
                    ];

                    $result = $model_user->addUser($query_vars);

                    if ($result) {
                        $_SESSION['form_data']['registration_success'] = 'Congratulations, you have successfully registered. Enter your login details.';
                        $this->response->redirect(Url::getUrl('/login'));
                    }

                    $data['error'] = 'Something went wrong.';
                }
            }

            $_SESSION['form_data'] = $data;

            $this->response->redirect(Url::getCurrentUrl());
        }
    }
}