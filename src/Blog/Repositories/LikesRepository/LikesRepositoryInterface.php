<?php

namespace Tgu\Savenko\Blog\Repositories\LikesRepository;

use Tgu\Savenko\Blog\Likes;

interface LikesRepositoryInterface
{
    public function saveLike(Likes $likes):void;
    public function getByPostUuid(string $uuid_post): Likes;
}