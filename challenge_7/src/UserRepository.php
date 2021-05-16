<?php

namespace UsersAPI;

use UsersAPI\UserModel;

class UserRepository
{
    private $fileUri;

    public function __construct(string $fileUri)
    {
        $this->fileUri = $fileUri;
    }

    public function getUsers(): array
    {
        $users = [];

        $handle = fopen($this->fileUri, 'r');

        while (($line = fgetcsv($handle, 1000)) !== false) {
            $users[] = new UserModel($line[0], $line[1], $line[2], $line[3]);
        }

        fclose($handle);

        return $users;
    }
}
