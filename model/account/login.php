<?php

class ModelAccountLogin extends Model
{
    public function getUser($email)
    {
      $sql = "SELECT * FROM user WHERE email = ?";
      $stmt = $this->db->prepare($sql);
      $stmt->execute([$email]);
      $result = $stmt->fetch();

      return $result;
    }
}