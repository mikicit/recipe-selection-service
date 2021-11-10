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
}