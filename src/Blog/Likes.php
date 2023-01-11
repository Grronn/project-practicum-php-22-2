<?php

namespace Tgu\Savenko\Blog;

class Likes
{
    public function __construct(
        private UUID   $id,
        private string $id_post,
        private string $id_user,
    )
    {
    }

    public function __toString(): string
    {
        $idLike = $this->getUuidLike();
        return "Like - $idLike on post $this->id_post where user - $this->id_user" . PHP_EOL;
    }

    public function getUuidLike(): UUID
    {
        return $this->id;
    }

    public function getUuidPost(): string
    {
        return $this->id_post;
    }

    public function getUuidUser(): string
    {
        return $this->id_user;
    }
}