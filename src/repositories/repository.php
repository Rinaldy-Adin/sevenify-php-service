<?php


namespace repositories;

use app\App;

class Repository
{
    protected $db;

    public function __construct()
    {
        $this->db = App::getDB();
    }
}
