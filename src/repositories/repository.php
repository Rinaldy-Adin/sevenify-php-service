<?php


namespace repositories;

use app\App;

class Repository
{
    protected $db;
    
    protected function __construct()
    {
        $this->db = App::getDB();
    }
}
