<?php 

/**
 * ControllerCommonHeader
 * 
 * This controller acts as a module to be called from another controller.
 */
class ControllerCommonHeader extends Controller
{
    /**
     * Returns HTML with data.
     * 
     * @param array $data
     * 
     * @return void
     */
    public function index($data = [])
    {
        $this->document->addStyle(Url::getUrl('/public/css/main.css'));
        $this->document->addStyle('http://fonts.cdnfonts.com/css/roboto');

        ## theme
        $data['theme'] = 'light';

        if (isset($_SESSION['theme']) && $_SESSION['theme'] === 'purple') {
            $data['theme'] = 'purple';
        }

        $data['user'] = $this->user->getCurrentUser();
        $data['title'] = $this->document->getTitle();
        $data['styles'] = $this->document->getStyles();
        
        return $this->view->get('common/header', $data);
    }
}