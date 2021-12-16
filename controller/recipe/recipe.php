<?php 

class ControllerRecipeRecipe extends Controller
{
    public function index()
    {  
        $model_recipe = new ModelRecipeRecipe();

        $data = [];

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();

        $query_vars = [
            'per_page' => 9,
            'page'     => 1
        ];

        if (isset($_GET['page']) && (int)$_GET['page'] > 1) {
            $query_vars['page'] = (int)$_GET['page'];
        }

        if (isset($_GET['ingredients']) && is_array($_GET['ingredients'])) {
            $query_vars['ingredients'] = $_GET['ingredients'];

            foreach ($query_vars['ingredients'] as $key => $ingredient) {
                $query_vars['ingredients'][$key] = (int)$ingredient;
            }
        }

        if (isset($_GET['categories']) && is_array($_GET['categories'])) {
            $query_vars['categories'] = $_GET['categories'];

            foreach ($query_vars['categories'] as $key => $category) {
                $query_vars['categories'][$key] = (int)$category;
            }
        }

        if (isset($_GET['search']) && is_string($_GET['search'])) {
            $search_length = strlen($_GET['search']);
            if ($search_length > 2 && $search_length < 100) {
                $query_vars['search'] = $_GET['search'];
            }
        }
        
        $data['ingredients'] = $model_recipe->getAllIngredients();
        $data['categories']  = $model_recipe->getAllCategories();
        $data['recipes']     = $model_recipe->getAll($query_vars);

        // foreach($data['recipes'] as $key => $recipe) {
        //     $data['recipes'][$key]['categories'] = $model_recipe->getCategories($recipe['recipe_id']);
        // }

        ## Pagination
        $max_pages = ceil($model_recipe->getQuantity($query_vars) / $query_vars['per_page']);

        if (isset($_GET['page']) && $query_vars['page'] > $max_pages) {
            $not_found = new ControllerErrorNotfound();
            $not_found->index();
        }

        $data['pagination'] = [];

        if ($max_pages > 1) {
            if ($query_vars['page'] > 1) {
                $data['pagination']['prev'] = Url::setVars(Url::getCurrentUrl(), ['page' => $query_vars['page'] - 1]);
            }
    
            if ($query_vars['page'] < $max_pages) {
                $data['pagination']['next'] = Url::setVars(Url::getCurrentUrl(), ['page' => $query_vars['page'] + 1]);
            }
    
            for ($i = 1; $i <= $max_pages; $i++) {
                $data['pagination']['items'][] = [
                    'page' => $i,
                    'link' => Url::setVars(Url::getCurrentUrl(), ['page' => $i]),
                    'current' => $query_vars['page'] == $i
                ];
            }
        }

        $this->document->setTitle('Recipes');

        $data['header'] = $header->index();
        $data['footer'] = $footer->index();
        
        $this->response->setOutput($this->view->get('recipe/recipes', $data));
    }

    public function show($query_vars)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $model_recipe = new ModelRecipeRecipe();

            $data = [];

            $header = new ControllerCommonHeader();
            $footer = new ControllerCommonFooter();

            $data['recipe'] = $model_recipe->get($query_vars['id']);

            if (!$data['recipe']) {
                $not_found = new ControllerErrorNotfound();
                $not_found->index();
            }

            $data['reviews'] = $model_recipe->getReviews($query_vars['id']);
            $data['ingredients'] = $model_recipe->getIngredients($query_vars['id']);
            $data['categories'] = $model_recipe->getCategories($query_vars['id']);

            ## session form data
            if (isset($_SESSION['form_data'])) {
                $data['form_data'] = $_SESSION['form_data'];
                unset($_SESSION['form_data']);
            }

            ## reviews pagination
            if (isset($_GET['page'])) {
                
            }

            $this->document->setTitle($data['recipe']['title']);

            $data['header'] = $header->index();
            $data['footer'] = $footer->index();

            $this->response->setOutput($this->view->get('recipe/recipe', $data));
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['user'])) return false;

            $model_recipe = new ModelRecipeRecipe();
            $data = [];
            
            ## getting POST data
            $data['user_id']   = $_SESSION['user']['user_id'];
            $data['recipe_id'] = isset($_POST['recipe_id']) ? (int)$_POST['recipe_id'] : 1;
            $data['review']    = isset($_POST['review']) ? trim(htmlspecialchars($_POST['review'])) : '';
            $data['rating']    = isset($_POST['rating']) ? (int)$_POST['rating'] : '';
            $data['review']    = preg_replace('/[\s]{2,}/', ' ', $data['review']); // deleting double spaces

            $data['validation'] = [];

            ## Validation

            ## Review
            if (strlen($data['review']) < 2) {
                $data['validation']['review'] = 'Review must not be shorter than 2 characters.';
            }

            if (strlen($data['review']) > 500) {
                $data['validation']['review'] = 'Review must not be longer than 500 characters.';
            }

            ## Rating
            if ($data['rating'] < 1 || $data['rating'] > 5) {
                $data['validation']['rating'] = 'Rating must be between 1 and 5.';
            }

            ## Rating
            if (empty($data['rating'])) {
                $data['validation']['rating'] = 'Please select a rating.';
            }

            if (empty($data['validation'])) {
                $result = $model_recipe->addReview([
                    'user_id'   => $data['user_id'],
                    'recipe_id' => $data['recipe_id'],
                    'review'    => $data['review'],
                    'rating'    => $data['rating'],
                    'review'    => $data['review'],
                ]);
                if ($result) {
                    $data['success'] = 'The review was successfully submitted.';
                } else {
                    $data['error'] = 'Something went wrong.';
                }
            }

            $_SESSION['form_data'] = $data;

            $this->response->redirect($_SERVER['REQUEST_URI']);
        }
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