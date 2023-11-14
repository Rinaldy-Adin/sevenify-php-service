<?php

namespace controllers\music;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'common/dto/musicWithArtistNameDTO.php';
require_once ROOT_DIR . 'services/musicService.php';
require_once ROOT_DIR . 'exceptions/UnsupportedMediaTypeException.php';

use common\dto\MusicWithArtistNameDTO;
use common\Response;
use exceptions\BadRequestException;
use services\MusicService;

class FindUserMusicController
{
    function get(): string
    {
        $userId = $_SESSION["user_id"];
        $page = isset($_GET['page']) ? urldecode($_GET['page']) : 1;

        $page = (int)$page;
        if (!is_int($page))
            throw new BadRequestException("Page requested not an integer");

        [$musicDTOs, $pageCount] = MusicService::getInstance()->getByUserID($userId, $page);
        $searchResult = array_map(fn (MusicWithArtistNameDTO $dto) => $dto->toDTOArray(), $musicDTOs);
        return (new Response(['result' => $searchResult, 'page-count' => $pageCount]))->httpResponse();
    }
}
