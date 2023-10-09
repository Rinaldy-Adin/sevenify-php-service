<?php

namespace controllers\music;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'common/dto/playlistWithArtistNameDTO.php';
require_once ROOT_DIR . 'services/playlistService.php';
require_once ROOT_DIR . 'exceptions/UnsupportedMediaTypeException.php';

use common\dto\PlaylistWithArtistNameDTO;
use common\Response;
use exceptions\BadRequestException;
use services\PlaylistService;

class FindUserPlaylistController
{
    function get(): string
    {
        $userId = isset($_GET['userId']) ? urldecode($_GET['userId']) :  $_SESSION["user_id"];
        $page = isset($_GET['page']) ? urldecode($_GET['page']) : 1;

        if (is_int($page))
            throw new BadRequestException("Page requested not an integer");

        [$playlistDTOs, $pageCount] = PlaylistService::getInstance()->getByUserID($userId, $page);
        $searchResult = array_map(fn(PlaylistWithArtistNameDTO $dto) => $dto->toDTOArray(), $playlistDTOs);
        return (new Response(['result' => $searchResult, 'page-count' => $pageCount]))->httpResponse();
    }
}