<?php

namespace Tgu\Savenko\Blog;

use Tgu\Savenko\Person\Person;

class Post{
    public function __construct(
        private string $text,
        public int $id,
        public int $authorId,
        private string $heading,

    )
    {

    }
    public function __toString():string{
        return 'ID статьи: ' . $this->id . ' ID автора: ' .$this->authorId . ' Заголовок: ' .$this->heading . ' Текст статьи: ' . $this->text;
    }
}