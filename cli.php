<?php

use Tgu\Savenko\Blog\Commands\Arguments;
use Tgu\Savenko\Blog\Commands\CreateUserCommand;
use Tgu\Savenko\Blog\Comment;
use Tgu\Savenko\Blog\Exceptions\ArgumentsException;
use Tgu\Savenko\Blog\Exceptions\CommandException;
use Tgu\Savenko\Blog\Post;
use Tgu\Savenko\Blog\Repositories\CommentsRepository\SqliteCommentsRepository;
use Tgu\Savenko\Blog\Repositories\PostsRepository\SqlitePostsRepository;
use Tgu\Savenko\Blog\Repositories\UsersRepository\InMemoryUsersRepository;
use Tgu\Savenko\Blog\Repositories\UsersRepository\SqliteUsersRepository;
use Tgu\Savenko\Blog\User;
use Tgu\Savenko\Blog\UUID;
use Tgu\Savenko\Person\Name;

require_once __DIR__ . '/vendor/autoload.php';

$connection = new PDO('sqlite:' . __DIR__ . '/blog.sqlite');

$userRepository = new SqliteUsersRepository($connection);
$postRepository = new SqlitePostsRepository($connection);
$commentRepository = new SqliteCommentsRepository($connection);
$userInMemoryRepository =new InMemoryUsersRepository();

//$userRepository->save(new User(
//    UUID::random(),
//    new Name(
//        'Peter',
//        'Nikylin'
//    ),
//    'admin'
//));

//$postRepository->savePost(new Post(
//    UUID::random(),
//    UUID::random(),
//    'title1',
//    'text1'
//));

//$commentRepository->saveComment(new Comment(
//    UUID::random(),
//    UUID::random(),
//    UUID::random(),
//    'textComment1'
//));

$command = new CreateUserCommand($userRepository);

try {
    $command->handle(Arguments::fromArgv($argv));
} catch (ArgumentsException|CommandException $exception) {
    echo $exception->getMessage();
}