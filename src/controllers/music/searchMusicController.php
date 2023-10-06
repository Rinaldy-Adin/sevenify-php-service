<?php

namespace controllers\music;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'common/dto/musicWithArtistNameDTO.php';
require_once ROOT_DIR . 'services/musicService.php';

use common\dto\MusicWithArtistNameDTO;
use common\Response;
use services\MusicService;

class SearchMusicController
{
    function get(): string
    {
        $searchValue = urldecode($_GET['search']);
        $page = isset($_GET['page']) ? urldecode($_GET['page']) : 1;

        [$musicDTOs, $pageCount] = (new MusicService())->searchMusic($searchValue, $page);
        $searchResult = array_map(fn(MusicWithArtistNameDTO $dto) => $dto->toDTOArray(), $musicDTOs);
        return (new Response(['result' => $searchResult, 'page-count' => $pageCount]))->httpResponse();
    }
}
