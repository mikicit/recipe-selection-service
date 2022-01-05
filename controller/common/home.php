<?php 

/**
 * ControllerCommonHome
 * 
 * The controller is responsible for the home page.
 */
class ControllerCommonHome extends Controller
{
    /**
     * Processing get and post requests on the home page.
     * 
     * @param array $data
     * 
     * @return void
     */
    public function index($data = [])
    {   
        $model_recipe = new ModelRecipeRecipe();
        $data['featured_recipes'] = $model_recipe->getFeatured();

        $this->document->setTitle('Hrecept.cz - Look for recipes by ingredients!');

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();
        
        $data['header'] = $header->index();
        $data['footer'] = $footer->index();

        $this->response->setOutput($this->view->get('common/home', $data));
    }
}