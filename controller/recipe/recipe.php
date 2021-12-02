<?php 

class ControllerRecipeRecipe extends Controller
{
    public function index()
    {  
        $model_recipe = new ModelRecipeRecipe();

        $data = [];

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();

        $data['recipes'] = $model_recipe->getData();
        $data['ingredients'] = $model_recipe->getAllIngredients();
        $data['categories'] = $model_recipe->getAllCategories();

        foreach($data['recipes'] as $key => $recipe) {
            $data['recipes'][$key]['categories'] = $model_recipe->getCategories($recipe['recipe_id']);
        }

        $this->document->setTitle('Recipes');

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

        $data['reviews'] = $model_recipe->getReviews($query_vars['id']);
        $data['avg_rating'] = 0;

        foreach ($data['reviews'] as $raview) {
            $data['avg_rating'] += $raview['rating'];
        }

        if (count($data['reviews'])) {
            $data['avg_rating'] = round($data['avg_rating'] / count($data['reviews']));
        }

        $data['ingredients'] = $model_recipe->getIngredients($query_vars['id']);
        $data['categories'] = $model_recipe->getCategories($query_vars['id']);

        $data['form_validation'] = [];

        ## POST processing
        if (isset($_SESSION['user']) && $_SERVER["REQUEST_METHOD"] == "POST") {
            $form_data = [];

            $form_data['user_id'] = $_SESSION['user']['user_id'];
            $form_data['recipe_id']  = isset($_POST['recipe_id']) ? (int)$_POST['recipe_id'] : 1;
            $form_data['review']  = isset($_POST['review']) ? trim(htmlspecialchars($_POST['review'])) : '';
            $form_data['rating'] = isset($_POST['rating']) ? (int)$_POST['rating'] : '';

            $form_data['review'] = preg_replace('/[\s]{2,}/', ' ', $form_data['review']);

            ## Review
            if (strlen($form_data['review']) < 2) {
                $data['form_validation']['review'] = 'Review must not be shorter than 2 characters.';
            }

            if (strlen($form_data['review']) > 500) {
                $data['form_validation']['review'] = 'Review must not be longer than 500 characters.';
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

        $this->document->setTitle($data['recipe']['title']);

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

        $data['ingredients'] = $model_recipe->getAllIngredients();
        $data['categories'] = $model_recipe->getAllCategories();

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();

        $data['form_validation'] = [];
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $form_data = [];

            $form_data['title']       = isset($_POST['description']) ? trim(htmlspecialchars($_POST['title'])) : '';
            $form_data['description'] = isset($_POST['description']) ? trim(htmlspecialchars($_POST['description'])) : '';
            $form_data['ingredients'] = isset($_POST['ingredients']) && is_array($_POST['ingredients']) ? $_POST['ingredients'] : [];
            $form_data['categories']  = isset($_POST['categories']) && is_array($_POST['categories']) ? $_POST['categories'] : [];
            $form_data['images']      = isset($_FILES['images']) && !empty($_FILES['images']['name'][0]) ? $_FILES['images'] : [];

            ## Images validation
            if (!empty($form_data['images'])) {
                ## Errors
                foreach ($form_data['images']['error'] as $error) {
                    if (!($error == 4 || $error == 0)) {
                        $data['form_error'] = 'Something went wrong.';
                        break;
                    }
                }

                ## Size
                foreach ($form_data['images']['size'] as $size) {
                    if ($size > 5242880) {
                        $data['form_validation']['images'] = 'The image must not be larger than 5 megabytes.';
                        break;
                    }
                }

                ## Type
                foreach ($form_data['images']['type'] as $type) {
                    if (!empty($type) && $type !== 'image/jpeg') {
                        $data['form_validation']['images'] = 'Unsupported image format.';
                        break;
                    }
                }
            }


            ## Ingredients Validation
            foreach ($form_data['ingredients'] as $key => $ingredient) {
                $form_data['ingredients'][$key] = (int)$ingredient;
            }

            ## Categories Validation
            foreach ($form_data['categories'] as $key => $ingredient) {
                $form_data['categories'][$key] = (int)$ingredient;
            }

            ## Descriptipn
            if (strlen($form_data['description']) < 2) {
                $data['form_validation']['description'] = 'Description must not be shorter than 2 characters.';
            }

            ## Descriptipn
            if (strlen($form_data['title']) < 2) {
                $data['form_validation']['title'] = 'Title must not be shorter than 2 characters.';
            }

            if (empty($data['form_validation'])) {
                $result = $model_recipe->add($form_data);

                if (!$result) {
                    $data['form_error'] = 'Something went wrong.';
                } else {
                    $_SESSION['recipe_adding_success'] = 'The recipe was successfully added.';
                    $this->response->redirect($_SERVER['REQUEST_URI']);
                }
            }
        }

        $this->document->setTitle('Add Recipe');
        
        $data['header'] = $header->index();
        $data['footer'] = $footer->index();

        $this->response->setOutput($this->view->get('recipe/add', $data));
    }
}