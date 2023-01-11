<?php

namespace Tgu\Savenko\Blog\Commands;

use Psr\Log\LoggerInterface;
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
        private UsersRepositoryInterface $usersRepository,
        private LoggerInterface $logger,
    )
    {

    }

    /**
     * @throws CommandException
     * @throws ArgumentsException
     */
    public function handle(Arguments $arguments):void
    {
        $this->logger->info('Create command started');
        $username=$arguments->get('username');

        if($this->userExists($username)) {
            $this->logger->warning("User already exists: $username");
            throw new CommandException(
                "User already exists $username"
            );
        }
        $uuid= UUID::random();
        $this->usersRepository->save(new User(
            $uuid,
            new Name(
                $arguments->get('first_name'),
                $arguments->get('last_name')
            ),
            $username
        ));
        $this->logger->info("User created: $uuid" );
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