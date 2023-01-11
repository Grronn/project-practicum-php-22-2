<?php

require_once __DIR__ . '/vendor/autoload.php';

use Tgu\Savenko\Blog\Comment;
use Tgu\Savenko\Blog\Post;
use Tgu\Savenko\Person\Name;
use Tgu\Savenko\Person\Person;

spl_autoload_register(function ($class)
{

    $file=str_replace('\\',DIRECTORY_SEPARATOR,$class);
    $file = str_replace('_',DIRECTORY_SEPARATOR,$file).'.php';
    if (file_exists($file)){
        require $file;
    }
});


$user = new Name(2,'Viktor', 'Goncharov');
$post = new Post("текст статьи", 1, 2, "заголовок статьи");
$comment = new Comment(1, $user->id, $post->id, 'текст комментария');

print $user;
print $post;
print $comment;