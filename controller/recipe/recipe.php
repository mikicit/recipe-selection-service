<?php 

/**
 * ControllerRecipeRecipe
 * 
 * The controller is responsible for the recipe pages.
 */
class ControllerRecipeRecipe extends Controller
{
    /**
     * Processing get and post requests on the recipes page.
     * 
     * @param array $data
     * 
     * @return void
     */
    public function index($data = [])
    {  
        $model_recipe = new ModelRecipeRecipe();

        ## Handling and Filtering Request Variables

        ## Default query vars
        $query_vars = [
            'per_page' => 3,
            'page'     => 1
        ];

        ## Ingredients and Categories filtering
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

        ## Search filtering
        if (isset($_GET['search']) && is_string($_GET['search'])) {
            $filtered_search = filter_var($_GET['search'], FILTER_SANITIZE_STRING);
            $query_vars['search'] = $filtered_search;
        }
        
        ## Defining maximum pages for pagination
        $max_pages = ceil($model_recipe->getQuantity($query_vars) / $query_vars['per_page']);
        
        ## Page var filtering
        if (isset($_GET['page']) && is_string($_GET['page'])) {
            $filter_page = filter_var($_GET['page'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => $max_pages]]);
            if (!$filter_page) {
                $not_found = new ControllerErrorNotfound();
                $not_found->index();
            }
            $query_vars['page'] = $filter_page;
        }

        ## Sorting vars filtering
        $available_vars_sorted_by = ['name', 'date', 'rating'];

        if (isset($_GET['sort_by']) && is_string($_GET['sort_by'])) {
            if (in_array($_GET['sort_by'], $available_vars_sorted_by)) {
                $query_vars['sort_by'] = $_GET['sort_by'];
            }
        }

        if (isset($_GET['sort_d']) && is_string($_GET['sort_d'])) {
            if ($_GET['sort_d'] == 'asc' || $_GET['sort_d'] == 'desc') {
                $query_vars['sort_d'] = $_GET['sort_d'];
            }
        }

        ## Getting all data
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

        ## generating sorting links
        $data['sorting_links'] = [
            'date_desc' => [
                'name' => 'Date (new to old)',
                'href' => Url::setVars(Url::getCurrentUrl(), ['sort_by' => 'date', 'sort_d' => 'desc']),
                'active' => false
            ],
            'date_asc' => [
                'name' => 'Date (old to new)',
                'href' => Url::setVars(Url::getCurrentUrl(), ['sort_by' => 'date', 'sort_d' => 'asc']),
                'active' => false
            ],
            'name_asc' => [
                'name' => 'Name (A to Z)',
                'href' => Url::setVars(Url::getCurrentUrl(), ['sort_by' => 'name', 'sort_d' => 'asc']),
                'active' => false
            ],
            'name_desc' => [
                'name' => 'Name (Z to A)',
                'href' => Url::setVars(Url::getCurrentUrl(), ['sort_by' => 'name', 'sort_d' => 'desc']),
                'active' => false
            ],
            'rating_desc' => [
                'name' => 'Rating (high to low)',
                'href' => Url::setVars(Url::getCurrentUrl(), ['sort_by' => 'rating', 'sort_d' => 'desc']),
                'active' => false
            ],
            'rating_asc' => [
                'name' => 'Rating (low to high)',
                'href' => Url::setVars(Url::getCurrentUrl(), ['sort_by' => 'rating', 'sort_d' => 'asc']),
                'active' => false
            ],
        ];

        ## making active sort link
        if (isset($query_vars['sort_by']) && isset($query_vars['sort_d'])) {
            $sorting_query_string = $query_vars['sort_by'] . '_' . $query_vars['sort_d'];
            $data['sorting_links'][$sorting_query_string]['active'] = true;
        }

        ## providing filtered query vars
        $data['query_vars'] = $query_vars;

        $this->document->setTitle('Recipes');

        $header = new ControllerCommonHeader();
        $footer = new ControllerCommonFooter();

        $data['header'] = $header->index([
            'query_vars' => $data['query_vars']
        ]);
        $data['footer'] = $footer->index();
        
        $this->response->setOutput($this->view->get('recipe/recipes', $data));
    }

    /**
     * Processing get and post requests on the recipe page.
     * 
     * @param mixed $query_vars
     * 
     * @return void
     */
    public function show($query_vars)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $data = [];

            $model_recipe = new ModelRecipeRecipe();
            $model_review = new ModelRecipeReview();

            $data['recipe'] = $model_recipe->get($query_vars['id']);
            $data['user'] = $this->user->getCurrentUser();

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

            $max_pages = ceil($data['review_quantity'] / $review_pagination['per_page']);

            ## Page var filtering
            if (isset($_GET['page']) && is_string($_GET['page'])) {
                $filter_page = filter_var($_GET['page'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => $max_pages]]);
                if (!$filter_page) {
                    $not_found = new ControllerErrorNotfound();
                    $not_found->index();
                }
                $review_pagination['page'] = $filter_page;
            }

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

            $header = new ControllerCommonHeader();
            $footer = new ControllerCommonFooter();

            $data['header'] = $header->index();
            $data['footer'] = $footer->index();

            $this->response->setOutput($this->view->get('recipe/recipe', $data));
        } 
        elseif ($_SERVER['REQUEST_METHOD'] == 'POST') 
        {   
            if (isset($_POST['add-review'])) {
                if (!($this->user->getCurrentUser())) return false;

                $model_review = new ModelRecipeReview();
                $user = $this->user->getCurrentUser();
                
                ## Removing html tags and spaces
                $data['review'] = isset($_POST['review']) ? preg_replace('/[\s]{2,}/', ' ', trim(htmlspecialchars($_POST['review']))) : '';
                $data['rating'] = isset($_POST['rating']) ? $_POST['rating'] : '';

                ## Validation
                $data['validation'] = [];

                ## Review
                $data['validation']['review'] = (function(& $data) {
                    if (strlen($data['review']) < 2) {
                        return 'Review must not be shorter than 2 characters.';
                    }
        
                    if (strlen($data['review']) > 500) {
                        return 'Review must not be longer than 500 characters.';
                    }
                })($data);

                ## Rating
                $data['validation']['rating'] = (function(& $data) {
                    if (empty($data['rating'])) {
                        return 'Please select a rating.';
                    }

                    $is_integer = filter_var($data['rating'], FILTER_VALIDATE_INT);
                    if (!$is_integer) {
                        return 'The score must be an integer.';
                    }

                    if ($data['rating'] < 1 || $data['rating'] > 5) {
                        return 'Rating must be between 1 and 5.';
                    }
                })($data);

                ## Deleting fields without errors
                $data['validation'] = array_filter($data['validation'], function($value) { return !empty($value); });

                if (empty($data['validation'])) {
                    $result = $model_review->add([
                        'user_id'   => $user['user_id'],
                        'recipe_id' => $query_vars['id'],
                        'review'    => $data['review'],
                        'rating'    => $data['rating'],
                    ]);
                    if ($result) {
                        $_SESSION['form_data']['success'] = 'The review was successfully submitted.';
                        $this->response->redirect(Url::getCurrentUrl() . '#review-section');
                    }
                    $data['error'] = 'Something went wrong.';
                }

                $_SESSION['form_data'] = $data;
                $this->response->redirect(Url::getCurrentUrl() . '#review-section');
            }
        }
    }

    /**
     * Processing get and post requests on the recipe add page.
     * 
     * @param array $data
     * 
     * @return void
     */
    public function add($data = [])
    {
        if (!($this->user->getCurrentUser()) || $this->user->getCurrentUser()['user_group_id'] != 1) {
            $this->response->redirect(Url::getUrl('/'));
        }

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $model_recipe = new ModelRecipeRecipe();

            $data['ingredients'] = $model_recipe->getAllIngredients();
            $data['categories'] = $model_recipe->getAllCategories();

            ## session form data
            if (isset($_SESSION['form_data'])) {
                $data['form_data'] = $_SESSION['form_data'];
                unset($_SESSION['form_data']);
            }

            $this->document->setTitle('Add Recipe');

            $header = new ControllerCommonHeader();
            $footer = new ControllerCommonFooter();
        
            $data['header'] = $header->index();
            $data['footer'] = $footer->index();

            $this->response->setOutput($this->view->get('recipe/add', $data));
        } 
        elseif ($_SERVER['REQUEST_METHOD'] == 'POST') 
        {
            if (isset($_POST['add-recipe'])) {
                $model_recipe = new ModelRecipeRecipe();

                ## Removing html tags and spaces
                $data['title']       = isset($_POST['title']) ? trim(htmlspecialchars($_POST['title'])) : '';
                $data['description'] = isset($_POST['description']) ? trim(htmlspecialchars($_POST['description'])) : '';
                $data['ingredients'] = isset($_POST['ingredients']) && is_array($_POST['ingredients']) ? $_POST['ingredients'] : [];
                $data['categories']  = isset($_POST['categories']) && is_array($_POST['categories']) ? $_POST['categories'] : [];
                $data['images']      = isset($_FILES['images']) && is_array($_FILES['images']) ? $_FILES['images'] : [];

                ## Validation
                $data['validation'] = [];

                ## Images
                $data['validation']['images'] = (function(& $data) {
                    if (empty($data['images'])) {
                        return 'Images are required.';
                    }

                    if (!is_array($data['images']['name'])) {
                        return 'Something went wrong.';
                    }

                    if (empty($data['images']['name'][0])) {
                        return 'Images are required.';
                    }

                    ## Errors
                    foreach ($data['images']['error'] as $error) {
                        if ($error !== 0) {
                            return 'Something went wrong.';
                        }
                    }

                    ## Size
                    foreach ($data['images']['size'] as $size) {
                        if ($size > 5242880) {
                            return 'The image must not be larger than 5 megabytes.';
                        }
                    }

                    ## Type
                    foreach ($data['images']['type'] as $type) {
                        if (!empty($type) && $type !== 'image/jpeg') {
                            return 'Unsupported image format. Only JPEG.';
                        }
                    }
                })($data);

                ## Ingredients and Categories filtering
                $filter_function = function($item) {
                    return filter_var($item, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
                };

                ## Ingredients Validation
                $data['ingredients'] = array_filter($data['ingredients'], $filter_function);
                if (empty($data['ingredients'])) {
                    $data['validation']['ingredients'] = 'Please select at least one ingredient.';
                }

                ## Categories Validation
                $data['categories'] = array_filter($data['categories'], $filter_function);
                if (empty($data['categories'])) {
                    $data['validation']['categories'] = 'Please select at least one category.';
                }

                ## Descriptipn
                $data['validation']['description'] = (function(& $data) {
                    if (strlen($data['description']) < 2) {
                        return 'Description must not be shorter than 2 characters.';
                    }

                    if (strlen($data['description']) > 10000) {
                        return 'Description must not be longer than 10 000 characters.';
                    }
                })($data);

                ## Title
                $data['validation']['title'] = (function(& $data) {
                    if (strlen($data['title']) < 2) {
                        return 'Title must not be shorter than 2 characters.';
                    }

                    if (strlen($data['title']) > 255) {
                        return 'Title must not be longer than 255 characters.';
                    }
                })($data);

                ## Deleting fields without errors
                $data['validation'] = array_filter($data['validation'], function($value) { return !empty($value); });

                if (empty($data['validation'])) {
                    $result = $model_recipe->add($data);

                    if (!$result) {
                        $data['error'] = 'Something went wrong.';
                    } else {
                        $_SESSION['form_data']['success'] = 'The recipe was successfully added.';
                        $this->response->redirect(Url::getCurrentUrl());
                    }
                }

                $_SESSION['form_data'] = $data;
                $this->response->redirect(Url::getCurrentUrl());
            }
        }
    }
}