<?php

namespace controllers\playlist;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'common/dto/musicWithArtistNameDTO.php';
require_once ROOT_DIR . 'services/playlistService.php';

use common\Response;
use models\PlaylistModel;
use services\PlaylistService;

class AdminGetPlaylistController
{
    function get(): string
    {
        $page = isset($_GET['page']) ? urldecode($_GET['page']) : 1;

        [$playlistDTOs, $pageCount] = UserService::getInstance()->getAllPlaylists($page);
        $searchResult = array_map(fn(PlaylistModel $model) => $model->toDTO(), $playlistDTOs);
        return (new Response(['result' => $searchResult, 'page-count' => $pageCount]))->httpResponse();
    }
}
