<?php

namespace Tgu\Savenko\Blog\Commands;

use Tgu\Savenko\Blog\Exceptions\ArgumentsException;
use Tgu\Savenko\Blog\Exceptions\CommandException;
use Tgu\Savenko\Blog\Exceptions\UserNotFoundException;
use Tgu\Savenko\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use Tgu\Savenko\Blog\User;
use Tgu\Savenko\Blog\UUID;
use Tgu\Savenko\Person\Name;

class CreateUserCommand
{
    public function __construct(
        private UsersRepositoryInterface $usersRepository
    )
    {

    }

    /**
     * @throws CommandException
     * @throws ArgumentsException
     */
    public function handle(Arguments $arguments):void
    {
        $username=$arguments->get('username');

        if($this->userExists($username)) {
            throw new CommandException(
                "User already exists $username"
            );
        }
        $this->usersRepository->save(new User(
            UUID::random(),
            new Name(
                $arguments->get('first_name'),
                $arguments->get('last_name')
            ),
            $username
        ));
    }

    public function userExists(string $username): bool
    {
        try{
            $this->usersRepository->getByUsername($username);
        } catch (UserNotFoundException)
        {
            return false;
        }
        return true;
    }
}