<?php

use Tgu\Savenko\Blog\Repositories\UsersRepository\SqliteUsersRepository;
use Tgu\Savenko\Blog\User;

require_once __DIR__ . '/vendor/autoload.php';

$connection = new PDO('sqlite:' . __DIR__ . '/blog.sqlite');

$userRepository = new SqliteUsersRepository($connection);

$userRepository->save(new User('Ivan','Nikitin'));
$userRepository->save(new User('Peter','Nikylin'));