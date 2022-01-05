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
        $data['user'] = $this->user->getCurrentUser();
        $data['title'] = $this->document->getTitle();
        
        return $this->view->get('common/header', $data);
    }
}