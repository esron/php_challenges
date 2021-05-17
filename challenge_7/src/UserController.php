<?php

declare(strict_types=1);

namespace UsersAPI;

use UsersAPI\UserRepository;
use UsersAPI\UserModel;

class UserController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsers()
    {
        return json_encode(['data' => $this->userRepository->getUsers()]);
    }

    public function deleteUser(string $email)
    {
        if ($this->userRepository->deleteUser($email)) {
            return json_encode(['data' => ['message' => 'User deleted']]);
        }

        http_response_code(422);

        return json_encode(['errors' => ['email' => "User with email $email not found"]]);
    }

    public function createUser(array $post)
    {
        $user = new UserModel(
            $post['firstName'],
            $post['lastName'],
            $post['email'],
            $post['phone']
        );

        return json_encode(['data' => $this->userRepository->saveUser($user)]);
    }

    public function updateUser(string $email, array $post)
    {
        $newUser = new UserModel(
            $post['firstName'],
            $post['lastName'],
            $post['email'],
            $post['phone']
        );

        return json_encode(['data' => $this->userRepository->updateUser($email, $newUser)]);
    }
}
