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
        $this->document->addScript(Url::getUrl('/public/js/main.js'));
        $this->document->addScript('https://kit.fontawesome.com/20f334d03f.js', ['crossorigin' => 'anonymous']);

        $data['scripts'] = $this->document->getScripts();
        return $this->view->get('common/footer', $data);
    }
}