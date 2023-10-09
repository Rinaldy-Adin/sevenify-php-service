<?php

namespace controllers\album;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/albumService.php';
require_once ROOT_DIR . 'exceptions/UnsupportedMediaTypeException.php';

use common\Response;
use exceptions\UnsupportedMediaTypeException;
use services\AlbumService;

class UpdateAlbumController
{
    function post(): string
    {
        $pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);
        $album_id = $pathEntries[count($pathEntries) - 1];

        $title = $_POST["title"];
        $user_id = $_POST["user-id"];
        $coverFile = $_FILES["cover-file"];
        $deleteCover = isset($_POST["delete-cover"]) ? true : false;
        $music_ids = isset($_POST["music"]) ? array_map(fn ($id) => (int)$id, $_POST["music"]) : [];

        if ($coverFile['error'] == 4) {
            $coverFile = null;
        }

        if ($coverFile) {
            $mime = $coverFile['type'];
            $pattern = '/^image\/.*/';

            if (!preg_match($pattern, $mime))
                throw new UnsupportedMediaTypeException("Cover file is not an image");
        }

        $musicModel = AlbumService::getInstance()->updateAlbum($album_id, $title, $user_id, $deleteCover, $coverFile, $music_ids);
        return (new Response($musicModel->toDTO()))->httpResponse();
    }
}
