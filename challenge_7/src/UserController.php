<?php

declare(strict_types=1);

namespace UsersAPI;

use UsersAPI\UserRepository;

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
}
