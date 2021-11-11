<?php

class ModelRecipeRecipes extends Model
{
    public function getData()
    {
        $db = App::$db;
        $stmt = $db->query('SELECT * FROM recipe');
        $data = $stmt->fetchAll();

        return $data;
    }

    public function get($query_vars) 
    {
        $db = App::$db;
        $stmt = $db->query('SELECT * FROM recipe WHERE recipe_id = ' . $query_vars['id']);

        return $stmt->fetch();
    }

    public function getReviews($recipe_id)
    {
        $db = App::$db;
        $stmt = $db->query('SELECT review.review_id, review.description, review.date_added, user.user_id, user.firstname, user.lastname FROM review LEFT JOIN user ON review.user_id = user.user_id');
        $data = $stmt->fetchAll();

        return $data;
    }
}