<?php

use Tgu\Savenko\Blog\Commands\Arguments;
use Tgu\Savenko\Blog\Commands\CreateUserCommand;
use Tgu\Savenko\Blog\Exceptions\ArgumentsException;
use Tgu\Savenko\Blog\Exceptions\CommandException;
use Tgu\Savenko\Blog\Repositories\UsersRepository\InMemoryUsersRepository;
use Tgu\Savenko\Blog\Repositories\UsersRepository\SqliteUsersRepository;
use Tgu\Savenko\Blog\User;
use Tgu\Savenko\Blog\UUID;
use Tgu\Savenko\Person\Name;

require_once __DIR__ . '/vendor/autoload.php';

$connection = new PDO('sqlite:' . __DIR__ . '/blog.sqlite');

$userRepository = new SqliteUsersRepository($connection);
$userInMemoryRepository =new InMemoryUsersRepository();

//$userRepository->save(new User(
//    UUID::random(),
//    new Name(
//        'Ivan',
//        'Nikitin'
//    ),
//    'user1'
//));
//$userRepository->save(new User(
//    UUID::random(),
//    new Name(
//        'Peter',
//        'Nikylin'
//    ),
//    'admin'
//));

//echo $userRepository->getByUuid(new UUID('7a5db242-1163-47d6-ad0d-866571bfb95f')) . PHP_EOL;
//
//echo $userRepository->getByUsername('admin') . PHP_EOL;
//
//$userInMemoryRepository->save(new User(
//    UUID::random(),
//    new Name(
//        'Peterr',
//        'Nikylinn'
//    ),
//    'admin'
//));

//echo $userInMemoryRepository->getByUsername('admin') . PHP_EOL;

$command = new CreateUserCommand($userRepository);

try {
    $command->handle(Arguments::fromArgv($argv));
} catch (ArgumentsException|CommandException $exception) {
    echo $exception->getMessage();
}