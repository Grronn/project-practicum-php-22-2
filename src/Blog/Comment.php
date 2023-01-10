<?php

namespace Tgu\Savenko\Blog;

class Comment
{
    public function __construct(
        public int $id,
        public int $authorId,
        public int $postId,
        private string $text,
    )
    {
    }

    public function __toString(): string
    {
        return 'ID комментраия: ' . $this->id . ' ID автора ' .$this->authorId . ' ID статьи: ' .$this->postId . ' текст комментария: ' . $this->text;
    }

}