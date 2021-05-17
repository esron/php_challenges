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
    private $userController;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepositoryMock = $this->createMock(UserRepository::class);

        $this->userController = new UserController($this->userRepositoryMock);
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
        ]), $this->userController->getUsers());
    }

    public function testItCanDeleteUsersByEmail()
    {
        $this->userRepositoryMock->method('deleteUser')
            ->willReturn(true);

        $this->assertEquals(json_encode([
            'data' => [
                'message' => 'User deleted',
            ]
        ]), $this->userController->deleteUser('esron.dtamar@gmail.com'));
    }

    public function testItReturnsErrorWhenTheEmailIsNotFound()
    {
        $email = 'esron.dtamar@gmail.com';
        $this->userRepositoryMock->method('deleteUser')
            ->willReturn(false);

        $this->assertEquals(json_encode([
            'errors' => [
                'email' => "User with email $email not found",
            ]
        ]), $this->userController->deleteUser($email));
    }

    public function testItCanCreateAnUser()
    {
        $user =  [
            'firstName' => 'Nicola',
            'lastName' => 'Tesla',
            'email' => 'nicola.tesla@edson.com',
            'phone' => '01912345678',
        ];

        $this->userRepositoryMock->method('saveUser')
            ->willReturn(new UserModel(
                $user['firstName'],
                $user['lastName'],
                $user['email'],
                $user['phone']
            ));

        $this->assertEquals(json_encode([
            'data' => $user,
        ]), $this->userController->createUser());
    }
}
