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
            break;
        case 'DELETE':
            echo $userController->deleteUser($_REQUEST['email']);
            break;
        case 'POST':
            $post = json_decode(file_get_contents('php://input'), true);
            echo $userController->createUser($post);
            break;
        default:
            return http_response_code(404);
    }

    return;
}

return http_response_code(404);
