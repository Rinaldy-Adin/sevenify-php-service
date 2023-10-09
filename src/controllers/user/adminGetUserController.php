<?php

namespace controllers\user;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'models/userModel.php';
require_once ROOT_DIR . 'services/userService.php';
require_once ROOT_DIR . 'exceptions/BadRequestException.php';

use common\Response;
use exceptions\BadRequestException;
use models\UserModel;
use services\UserService;

class AdminGetUserController
{
    function get(): string
    {
        $page = isset($_GET['page']) ? urldecode($_GET['page']) : 1;

        if (is_int($page))
            throw new BadRequestException("Page requested not an integer");

        [$userDTOs, $pageCount] = UserService::getInstance()->getAllUsersPaged($page);
        $searchResult = array_map(fn(UserModel $model) => $model->toDTO(), $userDTOs);
        return (new Response(['result' => $searchResult, 'page-count' => $pageCount]))->httpResponse();
    }
}
