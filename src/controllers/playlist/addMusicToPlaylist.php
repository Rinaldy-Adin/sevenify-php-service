<?php

namespace controllers\playlist;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/playlistService.php';

use common\Response;
use services\PlaylistService;

class AddMusicToPlaylist
{
    function post(): string
    {
        $pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);
        $playlist_id = $pathEntries[count($pathEntries) - 1];
        $music_id = $_POST['music_id'];

        PlaylistService::getInstance()->addMusicToPlaylist($playlist_id, $music_id);
        return (new Response(["message" => "Successfully added music to playlist"]))->httpResponse();
    }
}
