<?php declare(strict_types=1);

namespace Test;

use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use UsersAPI\UserModel;
use UsersAPI\UserRepository;

class UserRepositoryTest extends TestCase
{
    private $fileSystem;

    public function setUp(): void
    {
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
}
