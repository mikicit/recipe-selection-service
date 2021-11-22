<?php

class ModelAccountRegistration extends Model
{
    public function register($data)
    {
      $sql = "INSERT INTO user (user_group_id, password, firstname, lastname, email) VALUES (2,  :password, :firstname, :lastname, :email)";
      $stmt = $this->db->prepare($sql);
      
      return $stmt->execute($data);
    }

    public function emailExists($email)
    {
      $sql = "SELECT email FROM user WHERE email = ?";
      $stmt = $this->db->prepare($sql);
      $stmt->execute([$email]);
      $result = $stmt->fetchColumn();

      if (!empty($result)) {
        return true;
      }

      return false;
    }
}