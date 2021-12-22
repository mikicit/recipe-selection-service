<?php

class ModelRecipeReview extends Model
{
	public function add($data)
	{
		$sql = 'INSERT INTO review (user_id, recipe_id, description, rating) VALUES (:user_id, :recipe_id, :review, :rating)';
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
	}

	public function get($query_vars = [])
    {
		$default = [
			'id' => 1,
			'page' => 1,
			'per_page' => 6
		];

		$query_vars = array_merge($default, $query_vars);

        $sql = 'SELECT review.review_id, review.description, review.date_added, review.rating, user.user_id, user.firstname, user.lastname ';
        $sql .= 'FROM review ';
        $sql .= 'LEFT JOIN user ON review.user_id = user.user_id ';
        $sql .= 'WHERE review.recipe_id = :id ';
        $sql .= 'ORDER BY review.date_added DESC ';
        $sql .= 'LIMIT 0, :limit';

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id'   => $query_vars['id'],
            'limit' => $query_vars['per_page'] * $query_vars['page']
        ]);
        $result = $stmt->fetchAll();

        return $result;
    }

	public function getQuantity($query_vars = [])
	{	
		$default = [
			'id' => 1
		];

		$query_vars = array_merge($default, $query_vars);

		$sql = 'SELECT COUNT(*) as quantity FROM review ';
		$sql .= 'WHERE review.recipe_id = ?';

		$stmt = $this->db->prepare($sql);
		$stmt->execute([$query_vars['id']]);
		$result = $stmt->fetchColumn();

		return $result;
	}
}