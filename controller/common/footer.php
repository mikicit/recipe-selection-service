<?php 

/**
 * ControllerCommonFooter
 * 
 * This controller acts as a module to be called from another controller.
 */
class ControllerCommonFooter extends Controller
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
        return $this->view->get('common/footer', $data);
    }
}