<?php

namespace controllers\music;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/musicService.php';

use common\Response;
use services\MusicService;

class GetMusicController
{
    function get(): string
    {
        $pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);
        $music_id = $pathEntries[count($pathEntries) - 1];

        $musicModel = (MusicService::getInstance())->getMusicById($music_id);
        if ($musicModel) {
            return (new Response($musicModel->toDTO()))->httpResponse();
        } else {
            return (new Response(['message' => 'Music not found'], 400))->httpResponse();
        }
    }
}