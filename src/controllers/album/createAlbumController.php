<?php

namespace controllers\album;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/albumService.php';

use common\Response;
use services\AlbumService;

class CreateAlbumController
{
    function post(): string
    {
        $title = $_POST["title"];
        $user_id = $_SESSION["user_id"];
        $coverFile = $_FILES["cover-file"];

        if ($coverFile['error'] == 4) {
            $coverFile = null;
        }

        $musicModel = AlbumService::getInstance()->createAlbum($title, $user_id, $coverFile);
        return (new Response($musicModel->toDTO()))->httpResponse();
    }
}
