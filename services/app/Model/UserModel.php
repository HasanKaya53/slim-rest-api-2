<?php

namespace App\Model;
use App\Controller\BaseController;
class UserModel extends BaseController
{

    public function getUser($username, $password)
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
        $stmt->execute([$username, $password]);
        return $stmt->fetchAll();
    }



}