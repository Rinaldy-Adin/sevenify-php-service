<?php

define("ROOT_DIR", __DIR__ . '/');

require_once ROOT_DIR . 'app/app.php';

use app\App;

(new App)->run();