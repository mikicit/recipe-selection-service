<?php 

class ControllerRecipeRecipe extends Controller
{
    public function index()
    {  
        $model_recipe = new ModelRecipeRecipe();

        $data = [];

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();

        $data['header'] = $header->index();
        $data['footer'] = $footer->index();

        $data['recipes'] = $model_recipe->getData();
        $data['ingredients'] = $model_recipe->getAllIngredients();
        
        $this->response->setOutput($this->view->get('recipe/recipes', $data));
    }

    public function show($query_vars)
    {
        $model_recipe = new ModelRecipeRecipe();

        $data = [];

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();

        $data['header'] = $header->index();
        $data['footer'] = $footer->index();

        $data['recipe'] = $model_recipe->get($query_vars['id']);

        if (!$data['recipe'])
        {
            $not_found = new ControllerErrorNotfound();
            $not_found->index();
        }

        $data['reviews'] = $model_recipe->getReviews($query_vars['id']);
        $data['avg_rating'] = 0;

        foreach ($data['reviews'] as $raview) {
            $data['avg_rating'] += $raview['rating'];
        }

        if (count($data['reviews'])) {
            $data['avg_rating'] = round($data['avg_rating'] / count($data['reviews']));
        }

        $data['ingredients'] = $model_recipe->getIngredients($query_vars['id']);

        $data['form_validation'] = [];

        ## POST processing
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $form_data = [];

            $form_data['recipe_id']  = isset($_POST['recipe_id']) ? (int)$_POST['recipe_id'] : 1;
            $form_data['review']  = isset($_POST['review']) ? trim(htmlspecialchars($_POST['review'])) : '';
            $form_data['rating'] = isset($_POST['rating']) ? (int)$_POST['rating'] : '';

            ## Review
            if (strlen($form_data['review']) < 50) {
                $data['form_validation']['review'] = 'Review must not be shorter than 50 characters.';
            }

            ## Rating
            if ($form_data['rating'] < 1 || $form_data['rating'] > 5) {
                $data['form_validation']['rating'] = 'Rating must be between 1 and 5.';
            }

            ## Rating
            if (empty($form_data['rating'])) {
                $data['form_validation']['rating'] = 'Please select a rating.';
            }

            if (empty($data['form_validation'])) {
                $model_recipe->addReview($form_data);
            }
        }

        $this->response->setOutput($this->view->get('recipe/recipe', $data));
    }

    public function add()
    {
        $model_recipe = new ModelRecipeRecipe();

        $data = [];

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();

        $data['header'] = $header->index();
        $data['footer'] = $footer->index();

        $this->response->setOutput($this->view->get('recipe/add', $data));
    }
}