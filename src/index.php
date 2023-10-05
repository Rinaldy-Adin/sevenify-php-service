<?php

define("ROOT_DIR", __DIR__ . '/');
error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();

require_once ROOT_DIR . 'app/app.php';
require_once ROOT_DIR . 'config/config.php';

use app\App;
use config\Config;

(new Config(ROOT_DIR . '../.env'))->load();
(new App)->run();
