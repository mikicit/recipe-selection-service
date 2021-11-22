<?php 

class ControllerAccountRegistration extends Controller
{
    public function index()
    {
        $model_registration = new ModelAccountRegistration();
        $data = [];

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();

        $data['header'] = $header->index();
        $data['footer'] = $footer->index();

        $data['form_validation'] = [];

        ## POST processing
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $form_data = [];

            $form_data['password']  = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
            $form_data['firstname'] = isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : '';
            $form_data['lastname']  = isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : '';
            $form_data['email']     = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';

            ## Validation

            ## Firstname
            if (strlen($form_data['firstname']) < 2) {
                $data['form_validation']['firstname'] = 'Firstname must not be shorter than 2 characters.';
            }

            if (!preg_match("/^[a-zA-Z]*$/", $form_data['firstname'])) {
                $data['form_validation']['firstname'] = 'Only letters allowed.';
            }

            ## Lastname
            if (strlen($form_data['lastname']) < 2) {
                $data['form_validation']['lastname'] = 'Lastname must not be shorter than 2 characters.';
            }

            if (!preg_match("/^[a-zA-Z]*$/", $form_data['lastname'])) {
                $data['form_validation']['lastname'] = 'Only letters allowed.';
            }

            ## Email
            if (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['form_validation']['email'] = 'Invalid email format.';
            }
            
            ## Passwotd
            if (strlen($form_data['password']) < 8) {
                $data['form_validation']['password'] = 'Password must not be shorter than 8 characters.';
            }

            if (empty($data['form_validation'])) {
                ## Check if email exists
                if ($model_registration->emailExists($form_data['email'])) {
                    $data['form_error'] = 'A user with this Email already exists.';
                    
                    $this->response->setOutput($this->view->get('account/registration', $data));
                }

                ## Hash with salt
                $form_data['password'] = password_hash($form_data['password'], PASSWORD_DEFAULT);

                $result = $model_registration->register($form_data);

                if (!$result) {
                    $data['form_error'] = 'Something went wrong.';
                } else {
                    $this->response->redirect('profile');
                }
            }
        }
        
        $this->response->setOutput($this->view->get('account/registration', $data));
    }
}