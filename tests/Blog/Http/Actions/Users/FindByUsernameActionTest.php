<?php

namespace Tgu\Savenko\PhpUnit\Blog\Http\Actions\Users;

use JsonException;
use PHPUnit\Framework\TestCase;
use Tgu\Savenko\Blog\Exceptions\UserNotFoundException;
use Tgu\Savenko\Blog\Http\Actions\Users\FindByUsername;
use Tgu\Savenko\Blog\Http\ErrorResponse;
use Tgu\Savenko\Blog\Http\Request;
use Tgu\Savenko\Blog\Http\SuccessResponse;
use Tgu\Savenko\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use Tgu\Savenko\Blog\User;
use Tgu\Savenko\Blog\UUID;
use Tgu\Savenko\Person\Name;

class FindByUsernameActionTest extends TestCase
{
    private function userRepository(array $users): UsersRepositoryInterface
    {
        return new class($users) implements UsersRepositoryInterface {
            public function __construct(
                private array $users
            )
            {
            }

            public function save(User $user): void
            {
                // TODO: Implement save() method.
            }

            public function getByUsername(string $username): User
            {
                foreach ($this->users as $user) {
                    if ($user instanceof User && $username === $user->getUserName()) {
                        return $user;
                    }
                }
                throw new UserNotFoundException('Not found');
            }

            public function getByUuid(UUID $uuid): User
            {
                throw new UserNotFoundException('Not found');
            }
        };
    }


    /**
     * @runInSeparateProcess
     * @preserveGlobalState disable
     * @throws JsonException
     */
    public function testItReturnErrorResponseIdNoUsernameProvided(): void
    {
        $request = new Request([], [], '');
        $userRepository = $this->userRepository([]);
        $action = new FindByUsername($userRepository);
        $response = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->expectOutputString('{"success":false,"reason":"No such query param in the request: username"}');
        $response->send();
    }


    /**
     * @runInSeparateProcess
     * @preserveGlobalState disable
     */
    public function testItReturnErrorResponseIdUserNotFound(): void
    {
        $request = new Request(['username' => 'Ivan'], [], '');
        $userRepository = $this->userRepository([]);
        $action = new FindByUsername($userRepository);
        $response = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->expectOutputString('{"success":false,"reason":"Not found"}');
        $response->send();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disable
     * @throws JsonException
     */
    public function testItReturnSuccessfulResponse(): void
    {
        $request = new Request(['username' => 'ivan'], [], '');
        $userRepository = $this->userRepository([new User(
            UUID::random(),
            new Name('Ivan', 'Nikitin'),
            'Ivan')]);
        $action = new FindByUsername($userRepository);
        $response = $action->handle($request);
        $this->assertInstanceOf(SuccessResponse::class, $response);
        $this->expectOutputString('{"success":true,"data":{"username":"Ivan","name":"Ivan Nikitin"}}');
        $response->send();

    }
}