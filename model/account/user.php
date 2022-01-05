<?php

/**
 * ModelAccountUser
 * 
 * The model for working with the user entity.
 */
class ModelAccountUser extends Model
{
	/**
	 * Gets a user object by ID
	 * 
	 * @param int $id
	 * 
	 * @return array|bool returns false on request error
	 */
	public function getUserById(int $id)
	{
		$sql = "SELECT * FROM user WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([$id]);
		
		if ($result) {
			$result = $stmt->fetch();
		}

        return $result;
	}

	/**
	 * Gets a user object by Email
	 * 
	 * @param string $email
	 * 
	 * @return array|bool returns false on request error
	 */
	public function getUserByEmail(string $email)
	{
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([$email]);
        
		if ($result) {
			$result = $stmt->fetch();
		}

        return $result;
	}

	/**
	 * Adding a new user
	 * 
	 * @param array $data
	 * 
	 * @return bool
	 */
	public function addUser(array $data)
	{
        $sql = "INSERT INTO user (user_group_id, password, firstname, lastname, email) VALUES (2,  :password, :firstname, :lastname, :email)";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute($data);
        
        return $result;
	}
}