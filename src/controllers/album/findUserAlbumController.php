<?php

namespace controllers\album;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'common/dto/albumWithArtistNameDTO.php';
require_once ROOT_DIR . 'services/albumService.php';
require_once ROOT_DIR . 'exceptions/BadRequestException.php';

use common\dto\AlbumWithArtistNameDTO;
use common\Response;
use exceptions\BadRequestException;
use services\AlbumService;

class FindUserAlbumController
{
    function get(): string
    {
        $userId = isset($_GET['userId']) ? urldecode($_GET['userId']) : $_SESSION["user_id"];
        $page = isset($_GET['page']) ? urldecode($_GET['page']) : 1;

        $page = (int)$page;
        if (!is_int($page))
            throw new BadRequestException("Page requested not an integer");

        [$albumDTOs, $pageCount] = AlbumService::getInstance()->getByUserID($userId, $page);
        $searchResult = array_map(fn (AlbumWithArtistNameDTO $dto) => $dto->toDTOArray(), $albumDTOs);
        return (new Response(['result' => $searchResult, 'page-count' => $pageCount]))->httpResponse();
    }
}
