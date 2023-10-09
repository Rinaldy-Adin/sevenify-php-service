<?php

namespace controllers\music;

require_once ROOT_DIR . 'services/musicService.php';

use common\Response;
use services\MusicService;

class CreateMusicController
{
    function post(): string
    {
        $title = $_POST["title"];
        $genre = $_POST["genre"];
        $musicFile = $_FILES["music-file"];
        $coverFile = $_FILES["cover-file"];

        $user_id = $_SESSION["user_id"];

        if ($coverFile['error'] == 4) {
            $coverFile = null;
        }

        $musicModel = (MusicService::getInstance())->createMusic($user_id, $title, $genre, $musicFile, $coverFile);
        if ($musicModel !== null) {
            return (new Response($musicModel->toDTO()))->httpResponse();
        } else {
            http_response_code(500);
            return (new Response(['message' => 'Error uploading music'], 500))->httpResponse();
        }
    }
}
