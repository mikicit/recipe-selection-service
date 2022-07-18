<?php

/**
 * ModelRecipeReview
 * 
 * The model for working with the review entity.
 */
class ModelRecipeReview extends Model
{
	/**
	 * This method adds a new review.
	 * 
	 * @param mixed $data
	 * 
	 * @return bool
	 */
	public function add(array $data)
	{
		$sql = 'INSERT INTO review (user_id, recipe_id, description, rating) VALUES (:user_id, :recipe_id, :review, :rating)';
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
	}

	/**
	 * This method returns all reviews for a specific recipe, given the query variables.
	 * 
	 * @param array $query_vars
	 * 
	 * @return array
	 */
	public function get(array $query_vars = [])
    {
		$default = [
			'id' => 1,
			'page' => 1,
			'per_page' => 6
		];

		$query_vars = array_merge($default, $query_vars);

        $sql = 'SELECT review.review_id, review.description, review.date_added, review.rating, "user".user_id, "user".firstname, "user".lastname ';
        $sql .= 'FROM review ';
        $sql .= 'LEFT JOIN "user" ON review.user_id = "user".user_id ';
        $sql .= 'WHERE review.recipe_id = :id ';
        $sql .= 'ORDER BY review.date_added DESC ';
        $sql .= 'OFFSET 0 LIMIT :limit';

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            'id'   => $query_vars['id'],
            'limit' => $query_vars['per_page'] * $query_vars['page']
        ]);

		if ($result) {
			return $stmt->fetchAll();
		} else {
			return [];
		}
    }

	/**
	 * Returns the number of reviews for a specific post based on query variables.
	 * 
	 * @param array $query_vars
	 * 
	 * @return int|bool
	 */
	public function getQuantity(array $query_vars = [])
	{	
		$default = [
			'id' => 1
		];

		$query_vars = array_merge($default, $query_vars);

		$sql = 'SELECT COUNT(*) as quantity FROM review ';
		$sql .= 'WHERE review.recipe_id = ?';

		$stmt = $this->db->prepare($sql);
		$result = $stmt->execute([$query_vars['id']]);
		
		if ($result) {
			$result = $stmt->fetchColumn();
		}

		return $result;
	}
}