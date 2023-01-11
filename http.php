<?php

use Tgu\Savenko\Blog\Commands\CreateUserCommand;
use Tgu\Savenko\Blog\Http\Actions\Comments\CreateComment;
use Tgu\Savenko\Blog\Http\Actions\Posts\DeletePosts;
use Tgu\Savenko\Blog\Http\Actions\Users\CreateUser;
use Tgu\Savenko\Blog\Http\Actions\Users\FindByUsername;
use Tgu\Savenko\Blog\Http\ErrorResponse;
use Tgu\Savenko\Blog\Http\Request;
use Tgu\Savenko\Blog\Exceptions\HttpException;
use Tgu\Savenko\Blog\Repositories\CommentsRepository\SqliteCommentsRepository;
use Tgu\Savenko\Blog\Repositories\PostsRepository\SqlitePostsRepository;

require_once __DIR__ . '/vendor/autoload.php';

$container= require __DIR__ . '/bootstrap.php';

$request = new Request($_GET,$_SERVER,file_get_contents('php://input'));

try{
    $path=$request->path();
}
catch (HttpException $exception){
    (new ErrorResponse($exception->getMessage()))->send();
    return;
}
try {
    $method = $request->method();
}
catch (HttpException $exception){
    (new ErrorResponse($exception->getMessage()))->send();
    return;
}

//$routes =[
//    'GET'=>['/users/show'=>new FindByUsername(new SqliteUsersRepository(new PDO('sqlite:'.__DIR__.'/blog.sqlite'))),],
//    'POST'=>[
//        '/users/create'=>new CreateUser(
//            new SqliteUsersRepository(
//                new PDO('sqlite:'.__DIR__.'/blog.sqlite')
//            )
//        )
//    ],
//];
$routes =[
    'GET'=>['/users/show'=>FindByUsername::class,
    ],
    'POST'=>[
        '/users/create'=>CreateUser::class,
    ],
];


if (!array_key_exists($path,$routes[$method])){
    (new ErrorResponse('Not found'))->send();
    return;
}
$actionClassName = $routes[$method][$path];
$action = $container->get($actionClassName);
try {
    $response = $action->handle($request);
    $response->send();
}
catch (Exception $exception){
    (new ErrorResponse($exception->getMessage()))->send();
    return;
}
