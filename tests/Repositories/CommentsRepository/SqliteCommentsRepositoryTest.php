<?php

namespace Tgu\Savenko\PhpUnit\Repositories\CommentsRepository;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Tgu\Savenko\Blog\Comment;
use Tgu\Savenko\Blog\Exceptions\CommentNotFoundException;
use Tgu\Savenko\Blog\Exceptions\InvalidArgumentException;
use Tgu\Savenko\Blog\Repositories\CommentsRepository\SqliteCommentsRepository;
use Tgu\Savenko\Blog\UUID;
use Tgu\Savenko\PhpUnit\Blog\DummyLogger;

class SqliteCommentsRepositoryTest extends TestCase
{
    /**
     * @throws InvalidArgumentException
     */
    public function testItTrowsAnExceptionWhenCommentNotFound():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteCommentsRepository($connectionStub, new DummyLogger());

        $this->expectException(CommentNotFoundException::class);
        $this->expectExceptionMessage('Cannot get comment: newComment');

        $repository->getTextComment('newComment');
    }

    public function testItSaveCommentsToDatabase():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createMock(PDOStatement::class);

        $statementStub
            ->expects($this->once())
            ->method('execute')
            ->with([
                ':uuid_comment' =>'7a5db242-1163-47d6-ad0d-866571bfb95f',
                ':post_uuid'=>'71a9a1a5-caae-4bc4-9c29-ab7a91bcf002',
                ':author_uuid'=>'7a5db242-1163-47d6-ad0d-866571bfb95f',
                ':text_comment'=>'textComment'
            ]);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteCommentsRepository($connectionStub, new DummyLogger());

        $repository->saveComment( new Comment(
            new UUID('7a5db242-1163-47d6-ad0d-866571bfb95f'),
            '71a9a1a5-caae-4bc4-9c29-ab7a91bcf002',
            '7a5db242-1163-47d6-ad0d-866571bfb95f',
            'textComment'
        ));
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testItTrowsAnExceptionWhenUuidCommentNotFound():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteCommentsRepository($connectionStub, new DummyLogger());

        $this->expectException(CommentNotFoundException::class);
        $this->expectExceptionMessage('Cannot get comment: d97ad24b-7b10-4c7a-8a60-188d171d22d4');

        $repository->getByUuidComment(new UUID('d97ad24b-7b10-4c7a-8a60-188d171d22d4'));
    }
}