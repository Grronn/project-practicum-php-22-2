<?php

namespace Tgu\Savenko\Blog\Repositories\CommentsRepository;

use Tgu\Savenko\Blog\Comment;
use Tgu\Savenko\Blog\UUID;

interface CommentsRepositoryInterface
{

    public function saveComment(Comment $comment):void;
    public function getByUuidComment(UUID $uuid_comment): Comment;
}