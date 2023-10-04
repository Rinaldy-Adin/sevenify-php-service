<?php

namespace rest;

require_once ROOT_DIR . 'controllers/music/getMusicController.php';

use controllers\music\getMusicController\GetMusicController;

class APIRoutes {
    public static array $apiroutes = [
        ['/api/music', 'get', GetMusicController::class]
    ];
}