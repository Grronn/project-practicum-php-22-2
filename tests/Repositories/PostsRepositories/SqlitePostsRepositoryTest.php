<?php

namespace Tgu\Savenko\PhpUnit\Repositories\PostsRepositories;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Tgu\Savenko\Blog\Exceptions\InvalidArgumentException;
use Tgu\Savenko\Blog\Exceptions\PostNotFoundException;
use Tgu\Savenko\Blog\Post;
use Tgu\Savenko\Blog\Repositories\PostsRepository\SqlitePostsRepository;
use Tgu\Savenko\Blog\UUID;
use Tgu\Savenko\PhpUnit\Blog\DummyLogger;

class SqlitePostsRepositoryTest extends TestCase
{
    public function testItTrowsAnExceptionWhenPostNotFound():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqlitePostsRepository($connectionStub, new DummyLogger());

        $this->expectException(PostNotFoundException::class);
        $this->expectExceptionMessage('Cannot get post: newpost');

        $repository->getTextPost('newpost');
    }

    public function testItSavePostToDB():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createMock(PDOStatement::class);

        $statementStub
            ->expects($this->once())
            ->method('execute')
            ->with([
                ':uuid_post' =>'4f6ab02c-3a8a-49bb-b232-6e9dbbd36b94',
                ':author_uuid'=>'d97ad24b-7b10-4c7a-8a60-188d171d22d4',
                ':title'=>'title',
                ':text_post'=>'textpost']);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqlitePostsRepository($connectionStub, new DummyLogger());

        $repository->savePost(new Post(
            new UUID('4f6ab02c-3a8a-49bb-b232-6e9dbbd36b94'),
            'd97ad24b-7b10-4c7a-8a60-188d171d22d4',
            'title',
            'textpost'
        ));
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testItTrowsAnExceptionWhenUuidPostNotFound():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqlitePostsRepository($connectionStub, new DummyLogger());

        $this->expectException(PostNotFoundException::class);
        $this->expectExceptionMessage('Cannot get post: 4f6ab02c-3a8a-49bb-b232-6e9dbbd36b94');


        $repository->getByUuidPost(new UUID('4f6ab02c-3a8a-49bb-b232-6e9dbbd36b94'));
    }
}