<?php

namespace Tgu\Savenko\Blog\Repositories\UsersRepository;

use PDOStatement;
use Tgu\Savenko\Blog\User;
use Tgu\Savenko\Blog\UUID;

interface UsersRepositoryInterface
{
    public function save(User $user): void;

    public function getByUsername(string $username): User;
    public function getByUuid(UUID $uuid): User;

}