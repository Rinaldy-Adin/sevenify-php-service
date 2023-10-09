<?php

namespace controllers\playlist;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/playlistService.php';

use common\Response;
use services\PlaylistService;

class AdminDeletePlaylistController
{
    function delete(): string
    {
        $pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);

        if (!is_numeric($pathEntries[count($pathEntries) - 1]))
            return (new Response(['message' => 'Playlist id invalid'], 400))->httpResponse();

        $playlist_id = (int)$pathEntries[count($pathEntries) - 1];

        PlaylistService::getInstance()->deletePlaylist($playlist_id);
        return (new Response(['message' => 'Successfully deleted playlist']))->httpResponse();
    }
}
