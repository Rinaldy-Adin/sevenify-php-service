<?php

namespace controllers\music;

require_once ROOT_DIR . 'services/musicService.php';

use common\Response;
use services\MusicService;

class AdminDeleteMusicController
{
    function delete(): string
    {
        $pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);

        if (!is_numeric($pathEntries[count($pathEntries) - 1]))
            return (new Response(['message' => 'Music id invalid'], 400))->httpResponse();

        $music_id = (int)$pathEntries[count($pathEntries) - 1];

        (MusicService::getInstance())->deleteMusic($music_id);
        return (new Response(['message' => 'Successfully deleted music']))->httpResponse();
    }
}
