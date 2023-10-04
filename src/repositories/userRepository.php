<?php

namespace repositories;

require_once ROOT_DIR . 'repositories/repository.php';
require_once ROOT_DIR . 'models/userModel.php';

use models\UserModel;
use PDO;
use PDOException;

class UserRepository extends Repository
{
    public function getAllUsers()
    {
        $query = "SELECT * FROM users";
        $stmt = $this->db->query($query);

        $users = [];
        while ($row = $stmt->fetch()) {
            $user = new UserModel($row['user_id'], $row['user_name'], $row['user_password'], $row['role']);
            $users[] = $user;
        }

        return $users;
    }

    public function getUserByUsername(string $username)
    {
        $query = "SELECT * FROM users WHERE user_name = :user_name";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":user_name", $username);
        $stmt->execute();

        $row = $stmt->fetch();
        if ($row) {
            return new UserModel($row['user_id'], $row['user_name'], $row['user_password'], $row['role']);
        } else {
            return null;
        }
    }

    public function getUserById(int $id)
    {
        $query = "SELECT * FROM users WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":user_id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();
        if ($row) {
            return new UserModel($row['user_id'], $row['user_name'], $row['user_password'], $row['role']);
        } else {
            return null;
        }
    }

    public function createUser(string $username, string $hashedPassword)
    {
        $query = "INSERT INTO users (user_name, user_password, role)
                  VALUES (:username, :password, 'user')";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $hashedPassword);

        try {
            $stmt->execute();

            $userId = $this->db->lastInsertId();
            $user = $this->getUserById($userId);

            return $user;
        } catch (PDOException $e) {
            error_log("User registration error: " . $e->getMessage());
            return null;
        }
    }
}
