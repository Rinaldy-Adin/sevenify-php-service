<?php

namespace controllers\album;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'services/albumService.php';
require_once ROOT_DIR . 'exceptions/UnsupportedMediaTypeException.php';

use common\Response;
use exceptions\UnsupportedMediaTypeException;
use services\AlbumService;

class AddMusicToAlbum
{
    function post(): string
    {
        $pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);
        $album_id = $pathEntries[count($pathEntries) - 1];
        $music_id = $_POST['music_id'];

        AlbumService::getInstance()->addMusicToAlbum($album_id, $music_id);
        return (new Response(["message" => "Successfully added music to album"]))->httpResponse();
    }
}
