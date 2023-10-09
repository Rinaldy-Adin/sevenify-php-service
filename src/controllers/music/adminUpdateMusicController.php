<?php

namespace controllers\music;

require_once ROOT_DIR . 'services/musicService.php';

use common\Response;
use services\MusicService;

class AdminUpdateMusicController
{
    function post(): string
    {
        $pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);

        if (!is_numeric($pathEntries[count($pathEntries) - 1]))
            return (new Response(['message' => 'Music id invalid'], 400))->httpResponse();

        $musicId = (int)$pathEntries[count($pathEntries) - 1];
        $title = $_POST["title"];
        $genre = $_POST["genre"];
        $user_id = $_POST["user-id"];
        $deleteCover = isset($_POST["delete-cover"]) ? true : false;
        $coverFile = $_FILES["cover-file"];


        if ($coverFile['error'] == 4) {
            $coverFile = null;
        }

        
        $musicModel = (MusicService::getInstance())->updateMusic($musicId, $user_id, $title, $genre, $deleteCover, $coverFile);
        if ($musicModel !== null) {
            return (new Response($musicModel->toDTO()))->httpResponse();
        } else {
            http_response_code(500);
            return (new Response(['message' => 'Error updating music'], 500))->httpResponse();
        }
    }
}
