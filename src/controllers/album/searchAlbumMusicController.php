<?php

namespace controllers\album;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'common/dto/musicWithArtistNameDTO.php';
require_once ROOT_DIR . 'services/musicService.php';

use common\dto\MusicWithArtistNameDTO;
use common\Response;
use services\MusicService;

class SearchAlbumMusicController
{
    function get(): string
    {
        $albumId = isset($_GET['albumId']) ? urldecode($_GET['albumId']) : -1;
        $page = isset($_GET['page']) ? urldecode($_GET['page']) : 1;

        [$musicDTOs, $pageCount] = (MusicService::getInstance())->getByAlbumId($albumId, $page);
        $searchResult = array_map(fn(MusicWithArtistNameDTO $dto) => $dto->toDTOArray(), $musicDTOs);
        return (new Response(['result' => $searchResult, 'page-count' => $pageCount]))->httpResponse();
    }
}
