<?php

namespace controllers\playlist;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'common/dto/musicWithArtistNameDTO.php';
require_once ROOT_DIR . 'services/playlistService.php';
require_once ROOT_DIR . 'exceptions/BadRequestException.php';

use common\Response;
use exceptions\BadRequestException;
use models\PlaylistModel;
use services\PlaylistService;

class AdminGetPlaylistController
{
    function get(): string
    {
        $page = isset($_GET['page']) ? urldecode($_GET['page']) : 1;

        if (is_int($page))
            throw new BadRequestException("Page requested not an integer");

        [$playlistDTOs, $pageCount] = PlaylistService::getInstance()->getAllPlaylists($page);
        $searchResult = array_map(fn(PlaylistModel $model) => $model->toDTO(), $playlistDTOs);
        return (new Response(['result' => $searchResult, 'page-count' => $pageCount]))->httpResponse();
    }
}
