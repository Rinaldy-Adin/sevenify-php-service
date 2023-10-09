<?php

namespace controllers\album;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'common/dto/musicWithArtistNameDTO.php';
require_once ROOT_DIR . 'services/albumService.php';

use common\Response;
use models\MusicModel;
use services\AlbumService;

class AdminGetAlbumMusicController
{
    function get(): string
    {
        $pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);
        $album_id = $pathEntries[count($pathEntries) - 1];

        $musicModels = AlbumService::getInstance()->getAlbumMusic($album_id);
        $searchResult = array_map(fn(MusicModel $model) => $model->toDTO(), $musicModels);
        return (new Response($searchResult))->httpResponse();
    }
}
