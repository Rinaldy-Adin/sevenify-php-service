<?php

namespace controllers\music;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'common/dto/musicWithArtistNameDTO.php';
require_once ROOT_DIR . 'services/musicService.php';
require_once ROOT_DIR . 'exceptions/BadRequestException.php';

use common\dto\MusicWithArtistNameDTO;
use common\Response;
use exceptions\BadRequestException;
use services\MusicService;

class SearchMusicController
{
    function get(): string
    {
        $searchValue = isset($_GET['page']) ? urldecode($_GET['search']) : '';
        $page = isset($_GET['page']) ? urldecode($_GET['page']) : 1;
        $genre = isset($_GET['genre']) ? urldecode($_GET['genre']) : 1;
        $uploadPeriod = isset($_GET['upload-period']) ? urldecode($_GET['upload-period']) : 'all-time';
        $sort = isset($_GET['sort']) ? urldecode($_GET['sort']) : '';

        $page = (int)$page;
        if (!is_int($page))
            throw new BadRequestException("Page requested not an integer");

        [$musicDTOs, $pageCount] = (MusicService::getInstance())->searchMusic($searchValue, $page, $genre, $uploadPeriod, $sort);
        $searchResult = array_map(fn (MusicWithArtistNameDTO $dto) => $dto->toDTOArray(), $musicDTOs);
        return (new Response(['result' => $searchResult, 'page-count' => $pageCount]))->httpResponse();
    }
}
