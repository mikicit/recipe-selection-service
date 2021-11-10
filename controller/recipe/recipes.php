<?php 

class ControllerRecipeRecipes extends Controller
{
    public function show($id)
    {
        $view = new View();
        $model_recipes = new ModelRecipeRecipes();

        $data = [];

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();

        $data['header'] = $header->index();
        $data['footer'] = $footer->index();

        $data['recipe'] = $model_recipes->get($id);

        if (!$data['recipe']) 
        {
            die(); // Добавить редирект на 404
        }

        echo $view->get('recipe/recipe', $data);
    }

    public function index()
    {  
        $view = new View();
        $model_recipes = new ModelRecipeRecipes();

        $data = [];

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();

        $data['header'] = $header->index();
        $data['footer'] = $footer->index();

        $data['recipes'] = $model_recipes->getData();

        echo $view->get('recipe/recipes', $data);
    }
}