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

    public function saveUser(UserModel $user): UserModel
    {
        if ($handle = fopen($this->fileUri, 'a')) {
            fputcsv($handle, [
                $user->firstName,
                $user->lastName,
                $user->email,
                $user->phone,
            ]);

            fclose($handle);

            return $user;
        }

        return false;
    }

    private function updateUsersFile(array $users): bool
    {
        if ($handle = fopen($this->fileUri, 'w')) {
            foreach ($users as $user) {
                fputcsv($handle, [
                    $user->firstName,
                    $user->lastName,
                    $user->email,
                    $user->phone,
                ]);
            }

            fclose($handle);

            return true;
        }

        return false;
    }

    public function getUsers(): array
    {
        $users = [];

        if ($handle = fopen($this->fileUri, 'r')) {
            while (($line = fgetcsv($handle, 1000)) !== false) {
                $users[] = new UserModel($line[0], $line[1], $line[2], $line[3]);
            }

            fclose($handle);

            return $users;
        }

        return false;
    }

    public function deleteUser(string $email): bool
    {
        $users = [];

        if ($users = $this->getUsers()) {
            $newUsers = array_filter($users, fn ($user) => $user->email !== $email);

            return $this->updateUsersFile($newUsers);
        }

        return false;
    }
}
