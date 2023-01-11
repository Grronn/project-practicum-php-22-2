<?php

namespace Tgu\Savenko\Blog;

class Comment
{
    public function __construct(
        private UUID $uuidComment,
        private string $uuidPost,
        private string $uuidAuthor,
        private string $textComment,
    )
    {
    }

    public function __toString(): string
    {
        return 'ID комментраия: ' . $this->uuidComment . ' ID автора ' .$this->uuidAuthor . ' ID статьи: ' .$this->uuidPost . ' текст комментария: ' . $this->textComment;
    }
    public function getUuidComment():UUID{
        return $this->uuidComment;
    }
    public function getUuidPost():string{
        return $this->uuidPost;
    }
    public function getUuidAuthor():string{
        return $this->uuidAuthor;
    }
    public function getTextComment():string{
        return $this->textComment;
    }

}