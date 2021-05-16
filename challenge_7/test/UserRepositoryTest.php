<?php

declare(strict_types=1);

namespace Test;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;
use UsersAPI\UserModel;
use UsersAPI\UserRepository;

class UserRepositoryTest extends TestCase
{
    /**
     * @var vfsStreamDirectory
     */
    private $fileSystem;

    public function setUp(): void
    {
        parent::setUp();

        $this->fileSystem = vfsStream::setup('stub');
    }

    public function testItReturnsUsers()
    {
        // Creates temporary file
        vfsStream::newFile('users.txt')
            ->at($this->fileSystem)
            ->setContent(file_get_contents('test/stub/users.txt'));

        $userRepository = new UserRepository($this->fileSystem->url() . '/users.txt');

        $users = $userRepository->getUsers();

        $this->assertEquals([
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
        ], $users);
    }

    public function testItCanSaveAtLeastTwoUsers()
    {
        $fileName = $this->fileSystem->url() . '/new_users.txt';

        $userRepository = new UserRepository($fileName);

        $userRepository->saveUser(new UserModel('Alan', 'Turing', 'alan.turing@cam.ac.uk', '07911123456'));
        $userRepository->saveUser(new UserModel('Ada', 'Lovelace', 'ada.lovelace@london.ac.uk', '07966654321'));

        $expectedContent = <<<EOD
Alan,Turing,alan.turing@cam.ac.uk,07911123456
Ada,Lovelace,ada.lovelace@london.ac.uk,07966654321

EOD;

        $this->assertEquals($expectedContent, file_get_contents($fileName));
    }

    public function testItCanDeleteOneUserByEmail()
    {
        // Creates temporary file
        vfsStream::newFile('users.txt')
            ->at($this->fileSystem)
            ->setContent(file_get_contents('test/stub/users.txt'));

        $userRepository = new UserRepository($this->fileSystem->url() . '/users.txt');

        $userRepository->deleteUser('esron.dtamar@gmail.com');

        $this->assertEquals([
            new UserModel(
                'Silva',
                'Esron',
                'silva.esron@gmail.com',
                '87900000000'
            ),
        ], $userRepository->getUsers());
    }

    public function testItCanUpdateOneUserByEmail()
    {
        // Creates temporary file
        vfsStream::newFile('users.txt')
            ->at($this->fileSystem)
            ->setContent(file_get_contents('test/stub/users.txt'));

        $userRepository = new UserRepository($this->fileSystem->url() . '/users.txt');

        $edson = new UserModel(
            'Thomas',
            'Edson',
            'thomas@edson.com',
            '7488888888'
        );

        $userRepository->updateUser('esron.dtamar@gmail.com', $edson);

        $this->assertEquals([
            $edson,
            new UserModel(
                'Silva',
                'Esron',
                'silva.esron@gmail.com',
                '87900000000'
            ),
        ], $userRepository->getUsers());
    }
}
