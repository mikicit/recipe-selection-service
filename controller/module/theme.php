<?php 

/**
 * ControllerModuleTheme
 * 
 * This controller is used to switch themes
 */
class ControllerModuleTheme extends Controller
{
    /**
     * Processes get parameters for changing the theme and redirects to the page from which the request was made.
     * 
     * @param array $data
     * 
     * @return void
     */
    public function index($data = [])
    {
        if (isset($_GET['theme'])) {
            if ($_GET['theme'] === 'purple') {
                $_SESSION['theme'] = 'purple';
            } elseif ($_GET['theme'] === 'green') {
                $_SESSION['theme'] = 'green';
            }
        }

        $this->response->redirectToRef();
    }
}