<?php

namespace Tgu\Savenko\Blog\Repositories\CommentsRepository;

use PDO;
use PDOStatement;
use Psr\Log\LoggerInterface;
use Tgu\Savenko\Blog\Comment;
use Tgu\Savenko\Blog\Exceptions\CommentNotFoundException;
use Tgu\Savenko\Blog\Exceptions\InvalidArgumentException;
use Tgu\Savenko\Blog\UUID;

class SqliteCommentsRepository implements CommentsRepositoryInterface
{
    public function __construct(private PDO $connection, private LoggerInterface $logger)
    {

    }
    public function saveComment(Comment $comment): void
    {
        $this->logger->info('Save comment ');
        $statement = $this->connection->prepare(
            "INSERT INTO comments (uuid_comment, post_uuid, author_uuid, text_comment) VALUES (:uuid_comment,:post_uuid,:author_uuid, :text_comment)");
        $statement->execute([
            ':uuid_comment'=>(string)$comment->getUuidComment(),
            ':post_uuid'=>$comment->getUuidPost(),
            ':author_uuid'=>$comment->getUuidAuthor(),
            ':text_comment'=>$comment->getTextComment()]);
        $this->logger->info("'Save comment: $comment" );
    }

    /**
     * @throws CommentNotFoundException
     * @throws InvalidArgumentException
     */
    private function getComment(PDOStatement $statement, string $value):Comment{
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if($result===false){
            throw new CommentNotFoundException(
                "Cannot get comment: $value"
            );
        }
        return new Comment(
            new UUID($result['uuid_comment']),
            $result['post_uuid'],
            $result['author_uuid'],
            $result['text_comment']
        );
    }

    /**
     * @throws CommentNotFoundException
     * @throws InvalidArgumentException
     */
    public function getByUuidComment(UUID $uuid_comment): Comment
    {
        $statement = $this->connection->prepare(
            "SELECT * FROM comments WHERE uuid_comment = :uuid_comment"
        );
        $statement->execute([
            ':uuid_comment'=>(string)$uuid_comment
        ]);
        return $this->getComment($statement, (string)$uuid_comment);
    }

    /**
     * @throws CommentNotFoundException
     * @throws InvalidArgumentException
     */
    public function getTextComment(string $textCom):Comment
    {
        $statement = $this->connection->prepare("SELECT * FROM comments WHERE text_comment = :text_comment");
        $statement->execute([':text_comment'=>(string)$textCom]);
        return $this->getComment($statement, $textCom);
    }
}