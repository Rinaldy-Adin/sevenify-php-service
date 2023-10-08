<?php

namespace controllers\music;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'common/dto/playlistWithArtistNameDTO.php';
require_once ROOT_DIR . 'services/playlistService.php';

use common\dto\PlaylistWithArtistNameDTO;
use common\Response;
use services\PlaylistService;

class FindUserPlaylistController
{
    function get(): string
    {
        $userId = isset($_GET['userId']) ? urldecode($_GET['userId']) : 1;//Ganti User login
        $page = isset($_GET['page']) ? urldecode($_GET['page']) : 1;

        [$musicDTOs, $pageCount] = (new PlaylistService())->getByUserID($userId, $page);
        $searchResult = array_map(fn(PlaylistWithArtistNameDTO $dto) => $dto->toDTOArray(), $musicDTOs);
        return (new Response(['result' => $searchResult, 'page-count' => $pageCount]))->httpResponse();
    }
}