<?php

declare(strict_types=1);

namespace UsersAPI;

class UserModel
{
    public string $id;
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $phone;

    public function __construct(string $firstName, string $lastName, string $email, string $phone)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
    }
}
