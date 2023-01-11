<?php

namespace Tgu\Savenko\Blog;

use Tgu\Savenko\Person\Person;

class Post{
    public function __construct(
        private UUID $uuidPost,
        private string $uuidAuthor,
        private string $titlePost,
        private string $textPost,

    )
    {

    }
    public function __toString():string{
        return 'ID статьи: ' . $this->uuidPost . ' ID автора: ' .$this->uuidAuthor . ' Заголовок: ' .$this->titlePost . ' Текст статьи: ' . $this->textPost;
    }
    public function getUuidPost():UUID{
        return $this->uuidPost;
    }
    public function getUuidAuthor():string{
        return $this->uuidAuthor;
    }
    public function getTitlePost():string{
        return $this->titlePost;
    }
    public function getTextPost():string{
        return $this->textPost;
    }
}