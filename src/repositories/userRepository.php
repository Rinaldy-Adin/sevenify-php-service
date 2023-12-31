<?php

namespace repositories;

require_once ROOT_DIR . 'repositories/repository.php';
require_once ROOT_DIR . 'models/userModel.php';

use app\App;
use Exception;
use exceptions\AppException;
use models\UserModel;
use PDO;
use PDOException;

class UserRepository extends Repository
{
    private static $instance;
    
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }
    
    public function getAllUsers(?int $page = null)
    {
        $query = "SELECT * FROM users";
        $stmt = $this->db->query($query);

        $users = [];
        while ($row = $stmt->fetch()) {
            $user = new UserModel($row['user_id'], $row['user_name'], $row['user_password'], $row['role']);
            $users[] = $user;
        }

        if ($page) {
            $pageOffset = ($page - 1) * 5;
            return [array_slice($users, $pageOffset, 5), ceil(count($users) / 5)];
        } else {
            return [$users, 0];
        }
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

    public function createUser(string $username, string $hashedPassword, bool $isAdmin) : UserModel
    {
        $query = "INSERT INTO users (user_name, user_password, role)
                  VALUES (:username, :password, :role)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $hashedPassword);
        $isAdmin = $isAdmin ? "admin" : "user";
        $stmt->bindParam(":role", $isAdmin);

        try {
            $stmt->execute();

            $userId = $this->db->lastInsertId();
            $user = $this->getUserById($userId);

            return $user;
        } catch (PDOException $e) {
            error_log("User registration error: " . $e->getMessage());
            throw new AppException();
        }
    }

    public function deleteUser(int $userId): bool
    {
        $query = "DELETE FROM users WHERE user_id = :userId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);

        try {
            $stmt->execute();

            return true;
        } catch (Exception $e) {
            error_log("User deletion error: " . $e->getMessage());
            throw new AppException();
        }
    }

    public function updateUser(int $userId, string $username, string $hashedPassword, ?bool $isAdmin = null): UserModel
    {
        try {
            if ($hashedPassword !== '') {
                $query = "UPDATE users SET user_password = :password WHERE user_id = :userId";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(":password", $hashedPassword);
                $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
                $stmt->execute();
            }

            if ($username !== '') {
                $query = "UPDATE users SET user_name = :username WHERE user_id = :userId";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(":username", $username);
                $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
                $stmt->execute();
            }

            if ($isAdmin !== null) {
                $isAdmin = $isAdmin ? "admin" : "user";
                $query = "UPDATE users SET role = :role WHERE user_id = :userId";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(":role", $isAdmin);
                $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
                $stmt->execute();
            }

            $user = $this->getUserById($userId);

            return $user;
        } catch (PDOException $e) {
            error_log("User update error: " . $e->getMessage());
            throw new AppException();
        }
    }
}
