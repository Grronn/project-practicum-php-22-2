<?php

namespace Tgu\Savenko\Blog\Repositories\UsersRepository;

use Tgu\Savenko\Blog\Exceptions\UserNotFoundException;
use Tgu\Savenko\Blog\User;
use Tgu\Savenko\Blog\UUID;

class InMemoryUsersRepository implements UsersRepositoryInterface
{
    private array $users=[];
    public function save(User $user): void
    {
        $this->users[]=$user;
    }


    /**
     * @throws UserNotFoundException
     */
    public function getByUsername(string $username): User
    {
        foreach ($this->users as $user) {
            if ((string)$user->getUsername() === $username) {
                return $user;
            }
        }
        throw new UserNotFoundException("Users not found $username");
    }

    /**
     * @throws UserNotFoundException
     */
    public function getByUuid(UUID $uuid): User
    {
        foreach ($this->users as $user) {
            if ((string)$user->getUuid() === (string)$uuid)
                return $user;
        }
        throw new UserNotFoundException("Users not found $uuid");
    }
}