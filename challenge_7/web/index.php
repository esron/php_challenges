<?php

declare(strict_types=1);

use phpDocumentor\Reflection\DocBlock\Tags\Uses;

require_once(__DIR__ . '/../src/UserModel.php');
require_once(__DIR__ . '/../src/UserRepository.php');
require_once(__DIR__ . '/../src/UserController.php');

if ($_SERVER['PATH_INFO'] === '/users') {
    $usersFile = __DIR__ . '/../database/users.txt';

    $userRepository = new UsersAPI\UserRepository($usersFile);

    $userController = new UsersAPI\UserController($userRepository);


    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            echo $userController->getUsers();
    }
}

return http_response_code(404);
