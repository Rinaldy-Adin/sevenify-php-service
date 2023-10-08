<?php

namespace controllers\playlist;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'common/dto/musicWithArtistNameDTO.php';
require_once ROOT_DIR . 'services/playlistService.php';

use common\Response;
use models\MusicModel;
use services\PlaylistService;

class AdminGetPlaylistMusicController
{
    function get(): string
    {
        $pathEntries = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);
        $playlist_id = $pathEntries[count($pathEntries) - 1];

        $musicModels = (new PlaylistService())->getPlaylistMusic($playlist_id);
        $searchResult = array_map(fn(MusicModel $model) => $model->toDTO(), $musicModels);
        return (new Response($searchResult))->httpResponse();
    }
}
