<?php 

namespace controller;

class Recipes extends \core\Controller
{
    private $data = [];
    private $model;
    private $view;

    public function __construct()
    {
        if (class_exists('\model\Recipes'))
        {
            $this->model = new \model\Recipes;
        }

        $this->view = new \Core\View();

        $header = new Header();
        $footer = new Footer();

        $this->data['header'] = $header->index();
        $this->data['footer'] = $footer->index();
    }

    public function show($id)
    {
        echo $this->view->get('recipe/recipe', $this->data);
    }

    public function index()
    {
        echo $this->view->get('recipe/recipes', $this->data);
    }
}