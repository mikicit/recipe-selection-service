<?php

class ModelRecipeRecipe extends Model
{
    public function getData()
    {
        $dql = 'SELECT recipe.recipe_id, recipe.title, ROUND(AVG(review.rating)) as rating FROM recipe LEFT JOIN review ON recipe.recipe_id = review.recipe_id GROUP BY recipe.recipe_id ORDER BY recipe.date_added DESC';
        $stmt = $this->db->query($dql);
        
        if ($stmt) {
            return $stmt->fetchAll();
        } else {
            return [];
        }
    }

    public function get($id) 
    {
        $dql = 'SELECT * FROM recipe WHERE recipe_id = ?';
        $stmt = $this->db->prepare($dql);
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function getFeatured()
    {
        $sql = 'SELECT recipe.recipe_id, recipe.title, ROUND(AVG(review.rating)) as rating FROM recipe LEFT JOIN review ON recipe.recipe_id = review.recipe_id GROUP BY recipe.recipe_id ORDER BY rating DESC LIMIT 8';
        $stmt = $this->db->query($sql);

        if ($stmt) {
            return $stmt->fetchAll();
        } else {
            return [];
        }
    }

    public function getIngredients($id)
    {
        $sql = 'SELECT ingredient_recipe.ingredient_id, ingredient.name FROM ingredient_recipe LEFT JOIN ingredient ON ingredient.ingredient_id = ingredient_recipe.ingredient_id WHERE ingredient_recipe.recipe_id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetchAll();
    }

    public function getAllIngredients()
    {
        $sql = 'SELECT ingredient_id, name FROM ingredient ORDER BY name ASC';
        $stmt = $this->db->query($sql);

        if ($stmt) {
            return $stmt->fetchAll();
        } else {
            return [];
        }
    }

    public function getReviews($recipe_id)
    {
        $dql = 'SELECT review.review_id, review.description, review.date_added, review.rating, user.user_id, user.firstname, user.lastname FROM review LEFT JOIN user ON review.user_id = user.user_id WHERE review.recipe_id = ?';
        $stmt = $this->db->prepare($dql);
        $stmt->execute([$recipe_id]);
        $result = $stmt->fetchAll();

        return $result;
    }

    public function addReview($data)
    {
        $sql = 'INSERT INTO review (user_id, recipe_id, description, rating) VALUES (:user_id, :recipe_id, :review, :rating)';
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
    }
}