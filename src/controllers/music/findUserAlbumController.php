<?php

namespace controllers\music;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'common/dto/albumWithArtistNameDTO.php';
require_once ROOT_DIR . 'services/albumService.php';

use common\dto\AlbumWithArtistNameDTO;
use common\Response;
use services\AlbumService;

class FindUserAlbumController
{
    function get(): string
    {
        $userId = isset($_GET['userId']) ? urldecode($_GET['userId']) : 1;//Ganti User login
        $page = isset($_GET['page']) ? urldecode($_GET['page']) : 1;

        [$musicDTOs, $pageCount] = (new AlbumService())->getByUserID($userId, $page);
        $searchResult = array_map(fn(AlbumWithArtistNameDTO $dto) => $dto->toDTOArray(), $musicDTOs);
        return (new Response(['result' => $searchResult, 'page-count' => $pageCount]))->httpResponse();
    }
}
