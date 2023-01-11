<?php

namespace Tgu\Savenko\Blog\Repositories\PostsRepository;

use Tgu\Savenko\Blog\Post;
use Tgu\Savenko\Blog\UUID;

interface PostsRepositoryInterface
{
    public function savePost(Post $post):void;
    public function getByUuidPost(UUID $uuidPost): Post;
}