<?php

namespace repositories;

use models\UserModel;
use PDO;

class MusicRepository extends \Repository {
    public function getAllUsers() {
        $query = "SELECT * FROM users";
        $stmt = $this->db->query($query);

        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new UserModel($row['user_id'], $row['user_name'], $row['user_password'], $row['role']);
            $users[] = $user;
        }

        return $users;
    }

    public function getUserById($userId) {
        $query = "SELECT * FROM users WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new UserModel($row['user_id'], $row['user_name'], $row['user_password'], $row['role']);
        } else {
            return null;
        }
    }
}