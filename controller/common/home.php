<?php 

class ControllerCommonHome extends Controller
{
    public function index()
    {   
        $model_recipe = new ModelRecipeRecipe();

        $data = [];

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();

        $data['header'] = $header->index();
        $data['footer'] = $footer->index();

        $data['futured_recipes'] = $model_recipe->getFutured();

        $this->response->setOutput($this->view->get('common/home', $data));
    }
}