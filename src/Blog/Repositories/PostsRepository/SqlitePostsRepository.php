<?php

namespace Tgu\Savenko\Blog\Repositories\PostsRepository;

use PDO;
use PDOStatement;
use Tgu\Savenko\Blog\Exceptions\InvalidArgumentException;
use Tgu\Savenko\Blog\Exceptions\PostNotFoundException;
use Tgu\Savenko\Blog\Post;
use Tgu\Savenko\Blog\UUID;

class SqlitePostsRepository implements PostsRepositoryInterface
{

    public function __construct(private PDO $connection)
    {

    }
    public function savePost(Post $post): void
    {
        $statement = $this->connection->prepare(
            "INSERT INTO posts (uuid_post, author_uuid, title, text_post) VALUES (:uuid_post, :author_uuid, :title, :text_post)");
        $statement->execute([
            ':uuid_post'=>(string)$post->getUuidPost(),
            ':author_uuid'=>$post->getUuidAuthor(),
            ':title'=>$post->getTitlePost(),
            ':text_post'=>$post->getTextPost()]);
    }

    /**
     * @throws InvalidArgumentException
     * @throws PostNotFoundException
     */
    private function getPost(PDOStatement $statement, string $value):Post{
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if($result===false){
            throw new PostNotFoundException(
                "Cannot get post: $value"
            );
        }
        return new Post(
            new UUID($result['uuid_post']),
            $result['author_uuid'],
            $result['title'],
            $result['text_post']
        );
    }

    /**
     * @throws InvalidArgumentException
     * @throws PostNotFoundException
     */
    public function getByUuidPost(UUID $uuidPost): Post
    {
        $statement = $this->connection->prepare(
            "SELECT * FROM posts WHERE uuid_post = :uuid_post"
        );
        $statement->execute([
            ':uuid_post'=>(string)$uuidPost
        ]);
        return $this->getPost($statement, (string)$uuidPost);
    }

    public function getTextPost(string $text):Post
    {
        $statement = $this->connection->prepare("SELECT * FROM posts WHERE text_post = :text_post");
        $statement->execute([':text_post'=>(string)$text]);
        return $this->getPost($statement, $text);
    }
}