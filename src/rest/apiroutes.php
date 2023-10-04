<?php

namespace rest;

require_once ROOT_DIR . 'controllers/test.php';

use controllers\Test;

class APIRoutes {
    public static array $apiroutes = [
        ['/api/music', 'get', GetMusicController::class]
    ];
}