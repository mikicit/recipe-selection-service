<?php

class ModelAccountUser extends Model
{
	/**
	 * @param int $id
	 * 
	 * @return [type]
	 */
	public function getUserById(int $id)
	{
		$sql = "SELECT * FROM user WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();

        return $result;
	}

	/**
	 * @param string $email
	 * 
	 * @return [type]
	 */
	public function getUserByEmail(string $email)
	{
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        $result = $stmt->fetch();

        return $result;
	}

	/**
	 * @param array $data
	 * 
	 * @return [type]
	 */
	public function addUser(array $data)
	{
        $sql = "INSERT INTO user (user_group_id, password, firstname, lastname, email) VALUES (2,  :password, :firstname, :lastname, :email)";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute($data);
        
        return $result;
	}
}