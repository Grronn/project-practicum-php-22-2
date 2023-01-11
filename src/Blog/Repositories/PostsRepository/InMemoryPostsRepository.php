<?php

namespace Tgu\Savenko\Blog\Repositories\PostsRepository;

use Tgu\Savenko\Blog\Exceptions\PostNotFoundException;
use Tgu\Savenko\Blog\Post;
use Tgu\Savenko\Blog\UUID;

class InMemoryPostsRepository implements PostsRepositoryInterface
{
    private array $posts = [];
    public function savePost(Post $post): void
    {
        $this->posts[] = $post;
    }

    /**
     * @throws PostNotFoundException
     */
    public function getByUuidPost(UUID $uuidPost): Post
    {
        foreach ($this->posts as $post) {
            if ((string)$post->getUuid() === (string)$uuidPost)
                return $post;
        }
        throw new PostNotFoundException("Posts not found $uuidPost");
    }
}