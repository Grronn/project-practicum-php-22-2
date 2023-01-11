<?php

namespace Tgu\Savenko\Blog\Http\Actions\Posts;

use Tgu\Savenko\Blog\Exceptions\HttpException;
use Tgu\Savenko\Blog\Exceptions\PostNotFoundException;
use Tgu\Savenko\Blog\Http\Actions\ActionInterface;
use Tgu\Savenko\Blog\Http\ErrorResponse;
use Tgu\Savenko\Blog\Http\Request;
use Tgu\Savenko\Blog\Http\Response;
use Tgu\Savenko\Blog\Http\SuccessResponse;
use Tgu\Savenko\Blog\Repositories\PostsRepository\PostsRepositoryInterface;

class DeletePosts implements ActionInterface
{
    public function __construct(
        private PostsRepositoryInterface $postsRepository
    )
    {
    }
    public function handle(Request $request): Response
    {
        try {
            $uuid = $request->query('uuid_post');

        }
        catch (HttpException | PostNotFoundException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $this->postsRepository->getByUuidPost($uuid);
        return new SuccessResponse(['uuid_post'=>$uuid]);
    }
}