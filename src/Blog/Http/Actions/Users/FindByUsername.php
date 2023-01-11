<?php

namespace Tgu\Savenko\Blog\Http\Actions\Users;

use Tgu\Savenko\Blog\Exceptions\HttpException;
use Tgu\Savenko\Blog\Exceptions\UserNotFoundException;
use Tgu\Savenko\Blog\Http\Actions\ActionInterface;
use Tgu\Savenko\Blog\Http\ErrorResponse;
use Tgu\Savenko\Blog\Http\Request;
use Tgu\Savenko\Blog\Http\Response;
use Tgu\Savenko\Blog\Http\SuccessResponse;
use Tgu\Savenko\Blog\Repositories\UsersRepository\UsersRepositoryInterface;

class FindByUsername implements ActionInterface
{
    public function __construct(
        private UsersRepositoryInterface $usersRepository
    )
    {
    }

    public function handle(Request $request): Response
    {
        try {
            $username = $request->query('username');
            $user =$this->usersRepository->getByUsername($username);
        }
        catch (HttpException | UserNotFoundException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        return new SuccessResponse([
            'username'=>$user->getUserName(),
            'name'=>$user->getName()->getFirstName().' '.$user->getName()->getLastName()
        ]);
    }
}