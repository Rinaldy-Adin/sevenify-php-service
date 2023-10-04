<?php
namespace repositories;

require_once ROOT_DIR . 'repositories/repository.php';
require_once ROOT_DIR . 'models/userModel.php';

use models\UserModel;

class UserRepository extends Repository {
    public function getAllUsers() {
        $query = "SELECT * FROM users";
        $stmt = $this->db->query($query);

        $users = [];
        while ($row = $stmt->fetch()) {
            $user = new UserModel($row['user_id'], $row['user_name'], $row['user_password'], $row['role']);
            $users[] = $user;
        }

        return $users;
    }

    public function getUserByUsername($username) {
        $query = "SELECT * FROM users WHERE user_name = :user_name";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":user_name", $username);
        $stmt->execute();

        $row = $stmt->fetch();
        if ($row) {
            return new UserModel($row['user_id'], $row['user_name'], $row['user_password'], $row['role']);
        } else {
            return null; // User not found
        }
    }

}