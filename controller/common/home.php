<?php 

class ControllerCommonHome extends Controller
{
    public function index()
    {   
        $model_recipe = new ModelRecipeRecipe();

        $data = [];

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();

        $data['featured_recipes'] = $model_recipe->getFeatured();

        foreach($data['featured_recipes'] as $key => $recipe) {
            $data['featured_recipes'][$key]['categories'] = $model_recipe->getCategories($recipe['recipe_id']);
        }

        $this->document->setTitle('Hrecept.cz - Look for recipes by ingredients!');

        $data['header'] = $header->index();
        $data['footer'] = $footer->index();

        $this->response->setOutput($this->view->get('common/home', $data));
    }
}