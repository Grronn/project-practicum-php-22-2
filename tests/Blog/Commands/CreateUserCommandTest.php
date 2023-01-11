<?php

namespace Tgu\Savenko\PhpUnit\Blog\Commands;

use PHPUnit\Framework\TestCase;
use Tgu\Savenko\Blog\Commands\Arguments;
use Tgu\Savenko\Blog\Commands\CreateUserCommand;
use Tgu\Savenko\Blog\Exceptions\ArgumentsException;
use Tgu\Savenko\Blog\Exceptions\CommandException;
use Tgu\Savenko\Blog\Exceptions\UserNotFoundException;
use Tgu\Savenko\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use Tgu\Savenko\Blog\User;
use Tgu\Savenko\Blog\UUID;
use Tgu\Savenko\Person\Name;
use Tgu\Savenko\PhpUnit\Blog\DummyLogger;

class CreateUserCommandTest extends TestCase
{
    public function makeUsersRepository():UsersRepositoryInterface
    {
        return new class implements UsersRepositoryInterface
        {

            private bool $called=false;
            public function save(User $user): void
            {
                $this->called = true;
            }

            public function getByUsername(string $username): User
            {
                if($username === 'Ivan'){
                    return new User (UUID::random(), new Name('first','last'),'Ivan');
                }
                throw new UserNotFoundException('Not Found');
            }

            public function getByUuid(UUID $uuid): User
            {
                throw new UserNotFoundException('Not Found');
            }

            public function wasCalled(): bool
            {
                return $this->called;
            }
        };

    }

    /**
     * @throws ArgumentsException
     */
    public function testItThrowsAnExceptionWhenUserAlreadyExist():void
    {
        $command = new CreateUserCommand(
            $this->makeUsersRepository(),
            new DummyLogger(),
        );
        $this->expectException(CommandException::class);
        $this->expectExceptionMessage('User already exists Ivan');

        $command->handle(new Arguments([
            'username' => 'Ivan',
            'first_name' => 'Ivan',
            'last_name' => 'Ivanov'
        ]));
    }
    public function testItRequiresLastName(): void
    {
        $command = new CreateUserCommand(
            $this->makeUsersRepository(),
            new DummyLogger(),
        );

        $this->expectException(ArgumentsException::class);
        $this->expectExceptionMessage('No such argument: last_name');

        $command->handle(new Arguments([
            'username' => 'Ivan1',
            'first_name' => 'Ivan'
        ]));
    }

    public function testItRequiresFirstName(): void
    {
        $command = new CreateUserCommand(
            $this->makeUsersRepository(),
            new DummyLogger()
        );

        $this->expectException(ArgumentsException::class);
        $this->expectExceptionMessage('No such argument: first_name');

        $command->handle(new Arguments([
            'username' => 'Ivan1'
        ]));
    }

    public function testItSaveUserToRepository(): void
    {
        $userRepository = $this->makeUsersRepository();
        $command = new CreateUserCommand(
            $userRepository,
            new DummyLogger()
        );



        $command->handle(new Arguments([
            'username' => 'Ivan1',
            'first_name' => 'Ivan',
            'last_name' => 'Ivanov'
        ]));

        $this->assertTrue($userRepository->wasCalled());
    }
}