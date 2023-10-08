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

        $ok = (MusicService::getInstance())->deleteMusic($music_id);
        if ($ok) {
            return (new Response(['message' => 'Successfully deleted music']))->httpResponse();
        } else {
            http_response_code(500);
            return (new Response(['message' => 'Error deleting music'], 500))->httpResponse();
        }
    }
}
