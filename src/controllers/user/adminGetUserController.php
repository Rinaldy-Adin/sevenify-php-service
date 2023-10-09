<?php

namespace controllers\user;

require_once ROOT_DIR . 'common/response.php';
require_once ROOT_DIR . 'models/userModel.php';
require_once ROOT_DIR . 'services/userService.php';

use common\Response;
use models\UserModel;
use services\UserService;

class AdminGetUserController
{
    function get(): string
    {
        $page = isset($_GET['page']) ? urldecode($_GET['page']) : 1;

        [$userDTOs, $pageCount] = UserService::getInstance()->getAllUsersAdmin($page);
        $searchResult = array_map(fn(UserModel $model) => $model->toDTO(), $userDTOs);
        return (new Response(['result' => $searchResult, 'page-count' => $pageCount]))->httpResponse();
    }
}
