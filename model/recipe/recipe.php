<?php

/**
 * ModelRecipeRecipe
 * 
 * The model for working with the recipe entity.
 */
class ModelRecipeRecipe extends Model
{
    /**
     * This method returns all recipes given the request parameters. 
     * 
     * @param array $query_vars
     * 
     * @return array|bool
     */
    public function getAll(array $query_vars = [])
    {
        ## default query vars
        $default = [
            'per_page' => 12,
            'page'     => 1,
            'sort_by'  => 'date',
            'sort_d'   => 'desc'
        ];
        
        $query_vars = array_merge($default, $query_vars);

        ## creating SQL

        ## ingredient filter
        $ingredient_filter_sql = '1 = 1';

        if (isset($query_vars['ingredients'])) {
            $placeholder = '0';
            for ($i = 0; $i < count($query_vars['ingredients']); $i++) {
                $placeholder .= ", :ingredient$i";
            }
            $ingredient_filter_sql = "recipe.recipe_id IN (SELECT recipe_id FROM ingredient_recipe WHERE ingredient_recipe.ingredient_id IN ($placeholder))";
        }

        ## category filter
        $category_filter_sql = '1 = 1';

        if (isset($query_vars['categories'])) {
            $placeholder = '0';
            for ($i = 0; $i < count($query_vars['categories']); $i++) {
                $placeholder .= ", :category$i";
            }
            $category_filter_sql = "recipe.recipe_id IN (SELECT recipe_id FROM category_recipe WHERE category_recipe.category_id IN ($placeholder))";
        }

        ## search filter
        $search_filter_sql = '1 = 1';

        if (isset($query_vars['search'])) {
            $search_filter_sql = "recipe.title LIKE CONCAT('%', :search, '%')";
        }

        $filter_sql = "WHERE ($ingredient_filter_sql) AND ($category_filter_sql) AND ($search_filter_sql)";

        ## sorting
        $sorting_sql = 'ORDER BY ';

        ## sort by
        switch ($query_vars['sort_by']) {
            case 'date':
                $sorting_sql .= 'recipe.date_added ';
                break;
            case 'name':
                $sorting_sql .= 'recipe.title ';
                break;
            case 'rating':
                $sorting_sql .= 'rating ';
                break;
        }

        ## sort direction
        switch ($query_vars['sort_d']) {
            case 'desc':
                $sorting_sql .= 'DESC ';
                break;
            case 'asc':
                $sorting_sql .= 'ASC ';
                break;
        }

        $sql = 'SELECT recipe.recipe_id, recipe.title, recipe.images, ROUND(AVG(review.rating), 1) as rating ';
        $sql .= 'FROM recipe ';
        $sql .= 'LEFT JOIN review ON recipe.recipe_id = review.recipe_id ';
        $sql .= $filter_sql;
        $sql .= 'GROUP BY recipe.recipe_id ';
        $sql .= $sorting_sql;
        $sql .= 'LIMIT :offset, :per_page';
        
        $stmt = $this->db->prepare($sql);

        ## binding
        if (isset($query_vars['ingredients'])) {
            foreach ($query_vars['ingredients'] as $key => $ingredient) {
                $stmt->bindValue("ingredient$key", $ingredient);
            }
        }

        if (isset($query_vars['categories'])) {
            foreach ($query_vars['categories'] as $key => $category) {
                $stmt->bindValue("category$key", $category);
            }
        }

        if (isset($query_vars['search'])) {
            $stmt->bindValue("search", $query_vars['search']);
        }

        $stmt->bindValue('offset',  ($query_vars['page'] - 1) * $query_vars['per_page']);
        $stmt->bindValue('per_page', $query_vars['per_page']);

        $result = $stmt->execute();

        if ($result) {
            $result = $stmt->fetchAll();
        
            foreach ($result as $key => $recipe) {
                if (!empty($recipe['images'])) {
                    $result[$key]['images'] = (array)unserialize($recipe['images']);

                    foreach ($result[$key]['images'] as $index => $image) {
                        $result[$key]['images'][$index] = BASE_URL . '/uploads/recipes/' . $recipe['recipe_id'] . '/' . $image;
                    }
                }

                if (empty($recipe['rating'])) {
                    $result[$key]['rating'] = 0;
                }

                $result[$key]['rounded_rating'] = round($recipe['rating']);
            }
        }

        return $result;
    }

    /**
     * This method returns the number of recipes given the request parameters.
     * 
     * @param array $query_vars
     * 
     * @return int
     */
    public function getQuantity($query_vars = [])
    {
        ## creating SQL
        $ingredient_filter_sql = '1 = 1';

        if (isset($query_vars['ingredients'])) {
            $placeholder = '0';
            for ($i = 0; $i < count($query_vars['ingredients']); $i++) {
                $placeholder .= ", :ingredient$i";
            }
            $ingredient_filter_sql = "recipe.recipe_id IN (SELECT recipe_id FROM ingredient_recipe WHERE ingredient_recipe.ingredient_id IN ($placeholder))";
        }

        $category_filter_sql = '1 = 1';

        if (isset($query_vars['categories'])) {
            $placeholder = '0';
            for ($i = 0; $i < count($query_vars['categories']); $i++) {
                $placeholder .= ", :category$i";
            }
            $category_filter_sql = "recipe.recipe_id IN (SELECT recipe_id FROM category_recipe WHERE category_recipe.category_id IN ($placeholder))";
        }

        $search_filter_sql = '1 = 1';

        if (isset($query_vars['search'])) {
            $search_filter_sql = "recipe.title LIKE CONCAT('%', :search, '%')";
        }

        $filter_sql = "WHERE ($ingredient_filter_sql) AND ($category_filter_sql) AND ($search_filter_sql)";

        $sql = 'SELECT COUNT(*) as quantity FROM recipe ';
        $sql .= $filter_sql;

        $stmt = $this->db->prepare($sql);

        ## binding
        if (isset($query_vars['ingredients'])) {
            foreach ($query_vars['ingredients'] as $key => $ingredient) {
                $stmt->bindValue("ingredient$key", $ingredient);
            }
        }

        if (isset($query_vars['categories'])) {
            foreach ($query_vars['categories'] as $key => $category) {
                $stmt->bindValue("category$key", $category);
            }
        }

        if (isset($query_vars['search'])) {
            $stmt->bindValue("search", $query_vars['search']);
        }

        $result = $stmt->execute();
        
        if ($result) {
            $result = $stmt->fetch();
            if ($result) {
                return $result['quantity'];
            }
        }

        return 0;
    }

    /**
     * This method returns a recipe object by its ID.
     * 
     * @param int $id
     * 
     * @return array|bool
     */
    public function get(int $id)
    {
        $sql = 'SELECT recipe.recipe_id, recipe.title, recipe.description, recipe.images, ROUND(AVG(review.rating), 1) as rating, COUNT(review.recipe_id) as quantity ';
        $sql .= 'FROM recipe ';
        $sql .= 'LEFT JOIN review ';
        $sql .= 'ON review.recipe_id = recipe.recipe_id ';
        $sql .= 'WHERE recipe.recipe_id = ? ';
        $sql .= 'GROUP BY recipe.recipe_id';

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([$id]);
        
        if ($result) {
            $result = $stmt->fetch();

            if ($result) {
                if (!empty($result['images'])) {
                    $result['images'] = (array)unserialize($result['images']);
    
                    foreach ($result['images'] as $index => $image) {
                        $result['images'][$index] = BASE_URL . '/uploads/recipes/' . $result['recipe_id'] . '/' . $image;
                    }
                }
    
                if (empty($result['rating'])) {
                    $result['rating'] = 0;
                }
    
                $result['rounded_rating'] = round($result['rating']);
            }
        }

        return $result;
    }

    /**
     * This method returns an array of popular recipe objects.
     * 
     * @return array
     */
    public function getFeatured()
    {
        $sql = 'SELECT recipe.recipe_id, recipe.title, recipe.images, ROUND(AVG(review.rating), 1) as rating ';
        $sql .= 'FROM recipe ';
        $sql .= 'LEFT JOIN review ON recipe.recipe_id = review.recipe_id ';
        $sql .= 'GROUP BY recipe.recipe_id ';
        $sql .= 'ORDER BY rating DESC LIMIT 8';
        $sql .= '';
        
        $stmt = $this->db->query($sql);

        if ($stmt) {
            $result = $stmt->fetchAll();

            foreach ($result as $key => $recipe) {
                if (!empty($recipe['images'])) {
                    $result[$key]['images'] = (array)unserialize($recipe['images']);
    
                    foreach ($result[$key]['images'] as $index => $image) {
                        $result[$key]['images'][$index] = BASE_URL . '/uploads/recipes/' . $recipe['recipe_id'] . '/' . $image;
                    }
                }
                
                if (empty($recipe['rating'])) {
                    $result[$key]['rating'] = 0;
                }

                $result[$key]['rounded_rating'] = round($recipe['rating']);
            }

            return $result;
        } else {
            return [];
        }
    }

    /**
     * This method returns the ingredients associated with a specific recipe by ID.
     * 
     * @param int $id
     * 
     * @return array
     */
    public function getIngredients(int $id)
    {
        $sql = 'SELECT ingredient_recipe.ingredient_id, ingredient.name ';
        $sql .= 'FROM ingredient_recipe ';
        $sql .= 'LEFT JOIN ingredient ON ingredient.ingredient_id = ingredient_recipe.ingredient_id ';
        $sql .= 'WHERE ingredient_recipe.recipe_id = ?';
        
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([$id]);

        if ($result) {
            return $stmt->fetchAll();
        } else {
            return [];
        }
    }

    /**
     * This method returns an array of all ingredients.
     * 
     * @return array
     */
    public function getAllIngredients()
    {
        $sql = 'SELECT ingredient_id, name FROM ingredient ORDER BY name';
        $stmt = $this->db->query($sql);

        if ($stmt) {
            return $stmt->fetchAll();
        } else {
            return [];
        }
    }

    /**
     * This method returns the categories associated with a specific recipe by ID.
     * 
     * @param int $id
     * 
     * @return array
     */
    public function getCategories(int $id)
    {
        $sql = 'SELECT category_recipe.category_id, category.name ';
        $sql .= 'FROM category_recipe ';
        $sql .= 'LEFT JOIN category ON category.category_id = category_recipe.category_id ';
        $sql .= 'WHERE category_recipe.recipe_id = ?';
        
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([$id]);

        if ($result) {
            return $stmt->fetchAll();
        } else {
            return [];
        }
    }

    /**
     * This method returns an array of all categories.
     * 
     * @return array
     */
    public function getAllCategories()
    {
        $sql = 'SELECT category_id, name FROM category ORDER BY name';
        $stmt = $this->db->query($sql);

        if ($stmt) {
            return $stmt->fetchAll();
        } else {
            return [];
        }
    }

    /**
     * This method adds a new recipe.
     * 
     * @param array $data
     * 
     * @return bool
     */
    public function add(array $data)
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

            foreach ($data['categories'] as $category_id) {
                $this->db->query("INSERT INTO category_recipe (category_id, recipe_id) VALUES ($category_id, $recipe_id)");
            }

            if (!empty($data['images'])) {
                $path = ROOT . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'recipes' . DIRECTORY_SEPARATOR . $recipe_id . DIRECTORY_SEPARATOR;
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
}