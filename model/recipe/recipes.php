<?php

class ModelRecipeRecipes extends Model
{
    public function getData()
    {
        $db = App::$db;
        $stmt = $db->query('SELECT * FROM recipe');
        $data = [];

        while ($row = $stmt->fetch()) {
            $data[] = $row;
        }

        return $data;
    }

    public function get($query_vars) 
    {
        $db = App::$db;
        $stmt = $db->query('SELECT * FROM recipe WHERE recipe_id = ' . $query_vars['id']);

        return $stmt->fetch();
    }
}