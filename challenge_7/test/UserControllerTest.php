<?php

declare(strict_types=1);

namespace Test;

use PHPUnit\Framework\TestCase;
use UsersAPI\UserController;
use UsersAPI\UserRepository;
use UsersAPI\UserModel;

class UserControllerTest extends TestCase
{
    private $userRepositoryMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepositoryMock = $this->createMock(UserRepository::class);
    }
    public function testItReturnsUsers()
    {
        $returnUsers = [
            new UserModel(
                'Esron',
                'Silva',
                'esron.dtamar@gmail.com',
                '74999999999'
            ),
            new UserModel(
                'Silva',
                'Esron',
                'silva.esron@gmail.com',
                '87900000000'
            ),
        ];

        $this->userRepositoryMock->method('getUsers')
            ->willReturn($returnUsers);

        $userController = new UserController($this->userRepositoryMock);

        $this->assertEquals(json_encode([
            'data' => [
                [
                    'firstName' => 'Esron',
                    'lastName' => 'Silva',
                    'email' => 'esron.dtamar@gmail.com',
                    'phone' => '74999999999',
                ],
                [
                    'firstName' => 'Silva',
                    'lastName' => 'Esron',
                    'email' => 'silva.esron@gmail.com',
                    'phone' => '87900000000',
                ],
            ]
        ]), $userController->getUsers());
    }

    public function testItCanDeleteUsersByEmail()
    {
        $this->userRepositoryMock->method('deleteUser')
            ->willReturn(true);

        $userController = new UserController($this->userRepositoryMock);

        $this->assertEquals(json_encode([
            'data' => [
                'message' => 'User deleted',
            ]
        ]), $userController->deleteUser('esron.dtamar@gmail.com'));
    }

    public function testItReturnsErrorWhenTheEmailIsNotFound()
    {
        $email = 'esron.dtamar@gmail.com';
        $this->userRepositoryMock->method('deleteUser')
            ->willReturn(false);

        $userController = new UserController($this->userRepositoryMock);

        $this->assertEquals(json_encode([
            'errors' => [
                'email' => "User with email $email not found",
            ]
        ]), $userController->deleteUser($email));
    }
}
