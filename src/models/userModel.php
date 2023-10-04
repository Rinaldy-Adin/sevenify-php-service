<?php

namespace models;
use Model;

class UserModel extends Model {
    public $user_id;
    public $user_name;
    public $user_password;
    public $role;

    public function __construct(
        $user_id,
        $user_name,
        $user_password,
        $role
    ) {
        $this->user_id = $user_id;
        $this->user_name = $user_name;
        $this->user_password = $user_password;
        $this->role = $role;
    }
}