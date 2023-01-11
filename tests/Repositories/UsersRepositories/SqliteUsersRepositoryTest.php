<?php

namespace Tgu\Savenko\PhpUnit\Repositories\UsersRepositories;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Tgu\Savenko\Blog\Exceptions\InvalidArgumentException;
use Tgu\Savenko\Blog\Exceptions\UserNotFoundException;
use Tgu\Savenko\Blog\Repositories\UsersRepository\SqliteUsersRepository;
use Tgu\Savenko\Blog\User;
use Tgu\Savenko\Blog\UUID;
use Tgu\Savenko\Person\Name;

class SqliteUsersRepositoryTest extends TestCase
{
    /**
     * @throws InvalidArgumentException
     */
    public function testItTrowsAnExceptionWhenUserNotFound():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteUsersRepository($connectionStub);

        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage('Cannot get user: Ivan');

        $repository->getByUsername('Ivan');
    }

    public function testItSavesUserToDatabase():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createMock(PDOStatement::class);

        $statementStub
            ->expects($this->once())
            ->method('execute')
            ->with([
                ':uuid' =>'7a5db242-1163-47d6-ad0d-866571bfb95f',
                ':username'=>'user1',
                ':first_name'=>'Ivan',
                ':last_name'=>'Nikitin'
            ]);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteUsersRepository($connectionStub);

        $repository->save(new User(
            new UUID('7a5db242-1163-47d6-ad0d-866571bfb95f'),
            new Name('Ivan', 'Nikitin'),
            'user1'
        ));
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testItTrowsAnExceptionWhenUuidNotFound ():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteUsersRepository($connectionStub);
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage('Cannot get user: 7a5db242-1163-47d6-ad0d-866571bfb95f');

        $repository->getByUuid(new UUID('7a5db242-1163-47d6-ad0d-866571bfb95f'));
    }
}