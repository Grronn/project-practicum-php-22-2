<?php

namespace Tgu\Savenko\Blog\Http\Actions\Likes;

use Tgu\Savenko\Blog\Exceptions\HttpException;
use Tgu\Savenko\Blog\Http\Actions\ActionInterface;
use Tgu\Savenko\Blog\Http\ErrorResponse;
use Tgu\Savenko\Blog\Http\Request;
use Tgu\Savenko\Blog\Http\Response;
use Tgu\Savenko\Blog\Http\SuccessResponse;
use Tgu\Savenko\Blog\Likes;
use Tgu\Savenko\Blog\Repositories\LikesRepository\LikesRepositoryInterface;
use Tgu\Savenko\Blog\UUID;

class CreateLikes implements ActionInterface
{
    public function __construct(
        private LikesRepositoryInterface $likesRepository
    )
    {
    }
    public function handle(Request $request): Response
    {
        try {
            $newUuid = UUID::random();
            $like= new Likes($newUuid, $request->jsonBodyField('uuid_post'), $request->jsonBodyField('uuid_user'));
        }
        catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $this->likesRepository->saveLike($like);
        return new SuccessResponse(['uuid'=>(string)$newUuid]);
    }
}