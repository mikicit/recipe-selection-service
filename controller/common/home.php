<?php 

class ControllerCommonHome extends Controller
{
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