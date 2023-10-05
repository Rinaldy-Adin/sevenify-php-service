<?php


namespace repositories;

define("STORAGE_DIR", ROOT_DIR . '/../storage');

use app\App;

class Repository
{
    protected $db;

    public function __construct()
    {
        $this->db = App::getDB();
    }
}
