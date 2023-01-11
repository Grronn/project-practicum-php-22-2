<?php

namespace Tgu\Savenko\Blog\Http\Actions\Users;

use Tgu\Savenko\Blog\Exceptions\HttpException;
use Tgu\Savenko\Blog\Http\Actions\ActionInterface;
use Tgu\Savenko\Blog\Http\ErrorResponse;
use Tgu\Savenko\Blog\Http\Request;
use Tgu\Savenko\Blog\Http\Response;
use Tgu\Savenko\Blog\Http\SuccessResponse;
use Tgu\Savenko\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use Tgu\Savenko\Blog\User;
use Tgu\Savenko\Blog\UUID;
use Tgu\Savenko\Person\Name;

class CreateUser implements ActionInterface
{

    public function __construct(
        private UsersRepositoryInterface $usersRepository
    )
    {
    }

    public function handle(Request $request): Response
    {
        try {
            $newUserUuid = UUID::random();
            $user = new User(
                $newUserUuid,
                new Name(
                    $request->jsonBodyField('first_name'),
                    $request->jsonBodyField('last_name')
                ),
                $request->jsonBodyField('username'));
        }
        catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $this->usersRepository->save($user);
        return new SuccessResponse([
            'uuid'=>(string)$newUserUuid
        ]);
    }
}