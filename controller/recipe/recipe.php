<?php 

class ControllerRecipeRecipe extends Controller
{
    public function index()
    {  
        $this->document->setTitle('Recipes');

        $model_recipe = new ModelRecipeRecipe();

        $data = [];

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();

        $data['recipes'] = $model_recipe->getData();
        $data['ingredients'] = $model_recipe->getAllIngredients();

        $data['header'] = $header->index();
        $data['footer'] = $footer->index();
        
        $this->response->setOutput($this->view->get('recipe/recipes', $data));
    }

    public function show($query_vars)
    {
        $model_recipe = new ModelRecipeRecipe();

        $data = [];

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();

        $data['recipe'] = $model_recipe->get($query_vars['id']);

        if (!$data['recipe'])
        {
            $not_found = new ControllerErrorNotfound();
            $not_found->index();
        }

		$this->document->setTitle($data['recipe']['title']);

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
        if (isset($_SESSION['user']) && $_SERVER["REQUEST_METHOD"] == "POST") {
            $form_data = [];

            $form_data['user_id'] = $_SESSION['user']['user_id'];
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
                $_SESSION['review_adding_success'] = 'The review was successfully submitted.';
                $this->response->redirect($_SERVER['REQUEST_URI']);
            }
        }

		$data['header'] = $header->index();
        $data['footer'] = $footer->index();

        $this->response->setOutput($this->view->get('recipe/recipe', $data));
    }

    public function add()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['user_group_id'] != 1) {
            $this->response->redirect('/');
        }

        $model_recipe = new ModelRecipeRecipe();

        $data = [];

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();

        $data['header'] = $header->index();
        $data['footer'] = $footer->index();

        $this->response->setOutput($this->view->get('recipe/add', $data));
    }
}