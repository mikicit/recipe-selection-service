<?php

class ModelRecipeRecipe extends Model
{
    public function getData($query_vars = [])
    {
        $sql = 'SELECT recipe.recipe_id, recipe.title, recipe.images, ROUND(AVG(review.rating)) as rating ';
        $sql .= 'FROM recipe ';
        $sql .= 'LEFT JOIN review ON recipe.recipe_id = review.recipe_id ';
        $sql .= 'GROUP BY recipe.recipe_id ';
        $sql .= 'ORDER BY recipe.date_added DESC ';
        $sql .= 'LIMIT 0, 12';
        
        $stmt = $this->db->query($sql);
        $result = $stmt->fetchAll();
        
        if ($result) {
            foreach ($result as $key => $recipe) {
                if (!empty($recipe['images'])) {
                    $result[$key]['images'] = (array)unserialize($recipe['images']);

                    foreach ($result[$key]['images'] as $index => $image) {
                        $result[$key]['images'][$index] = PUBLIC_UPLOAD . 'recipes/' . $recipe['recipe_id'] . '/' . $image;
                    }
                }
            }

            return $result;
        } else {
            return [];
        }
    }

    public function get($id)
    {
        $sql = 'SELECT recipe.recipe_id, recipe.title, recipe.description, ROUND(AVG(review.rating)) as rating, COUNT(recipe.recipe_id) as quantity ';
        $sql .= 'FROM recipe ';
        $sql .= 'LEFT JOIN review ';
        $sql .= 'ON review.recipe_id = recipe.recipe_id ';
        $sql .= 'WHERE recipe.recipe_id = ? ';
        $sql .= 'GROUP BY recipe.recipe_id';

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function getFeatured()
    {
        $sql = 'SELECT recipe.recipe_id, recipe.title, ROUND(AVG(review.rating)) as rating ';
        $sql .= 'FROM recipe ';
        $sql .= 'LEFT JOIN review ON recipe.recipe_id = review.recipe_id ';
        $sql .= 'GROUP BY recipe.recipe_id ';
        $sql .= 'ORDER BY rating DESC LIMIT 8';
        $sql .= '';
        
        
        $stmt = $this->db->query($sql);

        if ($stmt) {
            return $stmt->fetchAll();
        } else {
            return [];
        }
    }

    public function getIngredients($id)
    {
        $sql = 'SELECT ingredient_recipe.ingredient_id, ingredient.name ';
        $sql .= 'FROM ingredient_recipe ';
        $sql .= 'LEFT JOIN ingredient ON ingredient.ingredient_id = ingredient_recipe.ingredient_id ';
        $sql .= 'WHERE ingredient_recipe.recipe_id = ?';
        
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

    public function getCategories($id)
    {
        $sql = 'SELECT category_recipe.category_id, category.name ';
        $sql .= 'FROM category_recipe ';
        $sql .= 'LEFT JOIN category ON category.category_id = category_recipe.category_id ';
        $sql .= 'WHERE category_recipe.recipe_id = ?';
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetchAll();
    }

    public function getAllCategories()
    {
        $sql = 'SELECT category_id, name FROM category ORDER BY name ASC';
        $stmt = $this->db->query($sql);

        if ($stmt) {
            return $stmt->fetchAll();
        } else {
            return [];
        }
    }

    public function getReviews($recipe_id)
    {
        $sql = 'SELECT review.review_id, review.description, review.date_added, review.rating, user.user_id, user.firstname, user.lastname ';
        $sql .= 'FROM review ';
        $sql .= 'LEFT JOIN user ON review.user_id = user.user_id ';
        $sql .= 'WHERE review.recipe_id = ? ';
        $sql .= 'ORDER BY review.date_added DESC ';
        $sql .= 'LIMIT 0, 2';

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$recipe_id]);
        $result = $stmt->fetchAll();

        return $result;
    }

    public function add($data)
    {
        try {
            $this->db->beginTransaction();

            $sql = 'INSERT INTO recipe (title, description) VALUES (:title, :description)';

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'title' => $data['title'],
                'description' => $data['description']
            ]);

            $recipe_id = $this->db->lastInsertId();

            foreach ($data['ingredients'] as $ingredient_id) {
                $this->db->query("INSERT INTO ingredient_recipe (ingredient_id, recipe_id) VALUES ($ingredient_id, $recipe_id)");
            }

            foreach ($data['categories'] as $cetegory_id) {
                $this->db->query("INSERT INTO category_recipe (category_id, recipe_id) VALUES ($cetegory_id, $recipe_id)");
            }

            if (!empty($data['images'])) {
                $path = UPLOAD . 'recipes' . DIRECTORY_SEPARATOR . $recipe_id . DIRECTORY_SEPARATOR;
                $images = [];

                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }
                
                foreach ($data['images']['tmp_name'] as $key => $tmp_name) {
                    $name = basename($data['images']['name'][$key]);
                    $result = move_uploaded_file($tmp_name, $path . $name);

                    if ($result) {
                        $images[] = $name;
                    }
                }

                $images = serialize($images);

                $stmt = $this->db->prepare("UPDATE recipe SET images = ? WHERE recipe_id = $recipe_id");
                $stmt->execute([$images]);
            }


            $this->db->commit();
        } catch (Exception $e) {
            print_r($e->getMessage());
            $this->db->rollBack();
            return false;
        }

        return true;
    }

    public function addReview($data)
    {
        $sql = 'INSERT INTO review (user_id, recipe_id, description, rating) VALUES (:user_id, :recipe_id, :review, :rating)';
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
    }
}