<?php

declare(strict_types=1);

namespace User\Service;

use User\Entity\User;
use User\Repository\UserRepository;

class UserService
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function create(string $username, string $email, string $phone, string $password): User
    {
        $user = User::create($username, $email, $phone, $password);
        return $this->repository->save($user);
    }
}
