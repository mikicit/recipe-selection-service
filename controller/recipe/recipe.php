<?php 

class ControllerRecipeRecipe extends Controller
{
    public function index()
    {  
        $model_recipe = new ModelRecipeRecipe();

        $data = [];

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();

        ## Handling and Filtering Request Variables
        $query_vars = [
            'per_page' => 9,
            'page'     => 1
        ];

        $filter_function = function($item) {
            return filter_var($item, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        };

        if (isset($_GET['ingredients']) && is_array($_GET['ingredients'])) {
            $filtered_ingredients = array_filter($_GET['ingredients'], $filter_function);
            if ($filtered_ingredients) $query_vars['ingredients'] =  $filtered_ingredients;
        }

        if (isset($_GET['categories']) && is_array($_GET['categories'])) {
            $filtered_categories = array_filter($_GET['categories'], $filter_function);
            if ($filtered_categories) $query_vars['categories'] =  $filtered_categories;
        }

        if (isset($_GET['search']) && is_string($_GET['search'])) {
            $search_length = strlen($_GET['search']);
            if ($search_length > 2 && $search_length < 100) {
                $query_vars['search'] = $_GET['search'];
            }
        }
        
        $max_pages = ceil($model_recipe->getQuantity($query_vars) / $query_vars['per_page']);
        
        if (isset($_GET['page'])) {
            $filter_page = filter_var($_GET['page'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => $max_pages]]);
            if (!$filter_page) {
                $not_found = new ControllerErrorNotfound();
                $not_found->index();
            }
            $query_vars['page'] = $filter_page;
        }
        
        $data['ingredients'] = $model_recipe->getAllIngredients();
        $data['categories']  = $model_recipe->getAllCategories();
        $data['recipes']     = $model_recipe->getAll($query_vars);

        ## Pagination
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

        $data['query_vars'] = $query_vars;

        $this->document->setTitle('Recipes');

        $data['header'] = $header->index();
        $data['footer'] = $footer->index();
        
        $this->response->setOutput($this->view->get('recipe/recipes', $data));
    }

    public function show($query_vars)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $model_recipe = new ModelRecipeRecipe();
            $model_review = new ModelRecipeReview();

            $data = [];

            $header = new ControllerCommonHeader();
            $footer = new ControllerCommonFooter();

            $data['recipe'] = $model_recipe->get($query_vars['id']);

            if (!$data['recipe']) {
                $not_found = new ControllerErrorNotfound();
                $not_found->index();
            }

            $data['review_quantity'] = $model_review->getQuantity($query_vars);

            ## reviews pagination
            $data['next_reviews'] = '';
            
            $review_pagination = [
                'per_page' => 6,
                'page' => 1
            ];

            if (isset($_GET['page']) && (int)$_GET['page'] > 1) {
                $review_pagination['page'] = (int)$_GET['page'];
            }

            $max_pages = ceil($data['review_quantity'] / $review_pagination['per_page']);

            if ($review_pagination['page'] < $max_pages) {
                $data['next_reviews'] = Url::setVars(Url::getCurrentUrl(), ['page' => $review_pagination['page'] + 1]) . '#reviews';
            }

            $data['reviews'] = $model_review->get([
                'id' => $query_vars['id'],
                'per_page' => $review_pagination['per_page'],
                'page' => $review_pagination['page']
            ]);

            $data['ingredients'] = $model_recipe->getIngredients($query_vars['id']);
            $data['categories'] = $model_recipe->getCategories($query_vars['id']);

            ## session form data
            if (isset($_SESSION['form_data'])) {
                $data['form_data'] = $_SESSION['form_data'];
                unset($_SESSION['form_data']);
            }

            $this->document->setTitle($data['recipe']['title']);

            $data['header'] = $header->index();
            $data['footer'] = $footer->index();

            $this->response->setOutput($this->view->get('recipe/recipe', $data));
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!(App::$user->isAuth())) return false;

            $model_review = new ModelRecipeReview();
            $data = [];
            $user = App::$user->getCurrentUser();
            
            ## getting POST data
            $data['user_id']   = $user['user_id'];
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
                $result = $model_review->add([
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
        if (!(App::$user->isAuth()) || App::$user->getCurrentUser()['user_group_id'] != 1) {
            $this->response->redirect('/');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $model_recipe = new ModelRecipeRecipe();

            $data = [];

            $data['ingredients'] = $model_recipe->getAllIngredients();
            $data['categories'] = $model_recipe->getAllCategories();

            ## session form data
            if (isset($_SESSION['form_data'])) {
                $data['form_data'] = $_SESSION['form_data'];
                unset($_SESSION['form_data']);
            }

            $header = new ControllerCommonHeader();
            $footer = new ControllerCommonFooter();

            $this->document->setTitle('Add Recipe');
        
            $data['header'] = $header->index();
            $data['footer'] = $footer->index();

            $this->response->setOutput($this->view->get('recipe/add', $data));
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model_recipe = new ModelRecipeRecipe();

            $data = [];

            $data['title']       = isset($_POST['description']) ? trim(htmlspecialchars($_POST['title'])) : '';
            $data['description'] = isset($_POST['description']) ? trim(htmlspecialchars($_POST['description'])) : '';
            $data['ingredients'] = isset($_POST['ingredients']) && is_array($_POST['ingredients']) ? $_POST['ingredients'] : [];
            $data['categories']  = isset($_POST['categories']) && is_array($_POST['categories']) ? $_POST['categories'] : [];
            $data['images']      = isset($_FILES['images']) && !empty($_FILES['images']['name'][0]) ? $_FILES['images'] : [];

            $data['validation'] = [];

            ## Validation

            ## Images validation
            if (!empty($data['images'])) {
                ## Errors
                foreach ($data['images']['error'] as $error) {
                    if (!($error == 4 || $error == 0)) {
                        $data['validation']['images'] = 'Something went wrong.';
                        break;
                    }
                }

                ## Size
                foreach ($data['images']['size'] as $size) {
                    if ($size > 5242880) {
                        $data['validation']['images'] = 'The image must not be larger than 5 megabytes.';
                        break;
                    }
                }

                ## Type
                foreach ($data['images']['type'] as $type) {
                    if (!empty($type) && $type !== 'image/jpeg') {
                        $data['validation']['images'] = 'Unsupported image format.';
                        break;
                    }
                }
            }

            ## Ingredients Validation
            foreach ($data['ingredients'] as $key => $ingredient) {
                $data['ingredients'][$key] = (int)$ingredient;
            }

            ## Categories Validation
            foreach ($data['categories'] as $key => $ingredient) {
                $data['categories'][$key] = (int)$ingredient;
            }

            ## Descriptipn
            if (strlen($data['description']) < 2) {
                $data['validation']['description'] = 'Description must not be shorter than 2 characters.';
            }

            ## Descriptipn
            if (strlen($data['title']) < 2) {
                $data['validation']['title'] = 'Title must not be shorter than 2 characters.';
            }

            if (empty($data['validation'])) {
                $result = $model_recipe->add($data);

                if (!$result) {
                    $data['error'] = 'Something went wrong.';
                } else {
                    $_SESSION['form_data']['success'] = 'The recipe was successfully added.';
                    $this->response->redirect($_SERVER['REQUEST_URI']);
                }
            }

            $_SESSION['form_data'] = $data;
            $this->response->redirect($_SERVER['REQUEST_URI']);
        }
    }
}