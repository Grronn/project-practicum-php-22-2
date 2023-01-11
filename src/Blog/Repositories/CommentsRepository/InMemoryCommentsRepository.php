<?php

namespace Tgu\Savenko\Blog\Repositories\CommentsRepository;

use Tgu\Savenko\Blog\Comment;
use Tgu\Savenko\Blog\Exceptions\CommentNotFoundException;
use Tgu\Savenko\Blog\UUID;

class InMemoryCommentsRepository implements CommentsRepositoryInterface
{
    private array $comments = [];
    public function saveComment(Comment $comment): void
    {
        $this->comments[] = $comment;
    }

    /**
     * @throws CommentNotFoundException
     */
    public function getByUuidComment(UUID $uuidComment): Comment
    {
        foreach ($this->comments as $comment) {
            if ((string)$comment->getUuid() === (string)$uuidComment)
                return $comment;
        }
        throw new CommentNotFoundException("Comments not found $uuidComment");
    }
}